<?php

namespace App\Http\Controllers;

use App\Models\Rent;
use App\Models\User;
use App\Models\Transaction;
use App\Models\PropertyRoom;
use App\Models\UserProperty;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Notifications\UserNotification;

class RentController extends Controller
{
    public function userRent()
    {
        $title = 'Pengajuan Sewa';
        $rents = Rent::where('user_id', auth()->user()->id)->orderBy('id', 'DESC')->paginate(10);

        return view('rent.userRent', compact(
            'title',
            'rents',
        ));
    }

    public function showUserRent($id)
    {
        $title = 'Pengajuan Sewa';
        $rent = Rent::find($id);
        $transaction = Transaction::where('rent_id', $rent->id)->where('active', 1)->first();

        return view('rent.showUserRent', compact(
            'title',
            'rent',
            'transaction',
        ));
    }

    public function ownerRent()
    {
        $title = 'Pengajuan Sewa';
        $rents = Rent::where('owner_id', auth()->user()->id)->orderBy('id', 'DESC')->paginate(10);

        return view('rent.ownerRent', compact(
            'title',
            'rents',
        ));
    }

    public function showOwnerRent($id)
    {
        $title = 'Pengajuan Sewa';
        $rent = Rent::find($id);

        return view('rent.showOwnerRent', compact(
            'title',
            'rent',
        ));
    }

    public function approvalOwnerRent(Request $request, $id)
    {
        $rent = Rent::find($id);
        DB::transaction(function ()  use ($request, $rent) {
            $validated = $request->validate([
                'status' => 'required',
                'owner_note' => 'nullable'
            ]);

            if ($request->status == 'Setuju') {
                $validated['status'] = 'Menunggu Pembayaran';
                $rent->update($validated);
                $user = User::find($rent->user_id);

                $transaction = Transaction::create([
                    'rent_id' => $rent->id,
                    'user_id' => $rent->user_id,
                    'owner_id' => $rent->owner_id,
                    'room_id' => $rent->room_id,
                    'property_id' => $rent->property_id,
                    'amount' => $rent->amount,
                    'deposit_price' => $rent->deposit_price,
                    'total_amount' => $rent->total_amount,
                    'start_date' => $rent->start_date,
                    'end_date' => $rent->end_date,
                    'period' => $rent->period,
                    'active' => 1,
                    'date' => date('Y-m-d'),
                    'in_out' => 'in',
                    'month' => date('m'),
                    'year' => date('Y'),
                    'status' => 'unpaid',
                    'created_by' => auth()->user()->id,
                ]);

                \Midtrans\Config::$serverKey = config('midtrans.server_key');
                \Midtrans\Config::$isProduction = config('midtrans.is_production');
                \Midtrans\Config::$isSanitized = true;
                \Midtrans\Config::$is3ds = true;

                $params = array(
                    'transaction_details' => array(
                        'order_id' => $transaction->id,
                        'gross_amount' => $rent->total_amount,
                    ),
                    'expiry' => array(
                        'start_time' => date("Y-m-d H:i:s O"),
                        'unit' => 'days',
                        'duration' => 7,
                    ),
                    'customer_details' => array(
                        'first_name' => $user->name ?? '',
                        'email' => $user->email ?? '',
                        'phone' => $user->no_hp,
                    ),
                );

                $snapToken = \Midtrans\Snap::getSnapToken($params);

                $transaction->update([
                    'snaptoken' => $snapToken
                ]);
            } else {
                $validated['status'] = 'Ditolak';
                $rent->update($validated);
            }
        });
        return redirect('/rent/owner/show/'.$rent->id)->with('success', 'Berhasil');
    }

    public function transactionCallback(Request $request)
    {
        $serverKey = config('midtrans.server_key');
        $hashed = hash('sha512', $request->order_id.$request->status_code.$request->gross_amount.$serverKey);
        if ($hashed == $request->signature_key) {
            $transaction = Transaction::find($request->order_id);
            $rent = Rent::find($transaction->rent_id);
            if ($request->transaction_status == 'capture' || $request->transaction_status == 'settlement') {
                $transaction->update([
                    'status' => 'paid',
                    'payment_source' => 'midtrans',
                    'payment_method' => $request->payment_type,
                    'paid_date' => $request->transaction_time,
                    'midtrans_transaction_id' => $request->transaction_id,
                    'active' => 0,
                ]);

                $rent->update([
                    'status' => 'Pembayaran Berhasil',
                ]);

                $room = PropertyRoom::find($transaction->room_id);
                $room->update([
                    'is_available' => 1,
                ]);

                if ($transaction->property) {
                    $property_name = $transaction->property->name;
                } else {
                    $property_name = '';
                }

                if ($transaction->property && $transaction->property->village) {
                    $village_name = $transaction->property->village->name;
                } else {
                    $village_name = '';
                }

                $message_user = 'Terimakasih anda telah melakukan pembayaran sewa Kos ' . ucwords(strtolower($property_name)) . ' ' . ucwords(strtolower($village_name)) . ' sebesar Rp ' . number_format($transaction->total_amount);
                $action_user = '/rent/user/show/'.$transaction->rent_id;

                $user = User::find($transaction->user_id);
                $data_user = [
                    'user_id'   =>  $transaction->user_id,
                    'from'   =>  $transaction->user->name,
                    'message'   =>  $message_user,
                    'action'   =>  $action_user
                ];

                $user->notify(new UserNotification($data_user));

                $message_owner = $transaction->user->name . ' berhasil melakukan pembayaran sewa Kos ' . ucwords(strtolower($property_name)) . ' ' .  ucwords(strtolower($village_name)) . ' sebesar Rp ' . number_format($transaction->total_amount);
                $action_owner = '/rent/owner/show/'.$transaction->rent_id;

                $owner = User::find($transaction->owner_id);
                $data_owner = [
                    'user_id'   =>  $transaction->owner_id,
                    'from'   =>  $transaction->user->name,
                    'message'   =>  $message_owner,
                    'action'   =>  $action_owner
                ];

                $owner->notify(new UserNotification($data_owner));

                $owner->update([
                    'balance' => $owner->balance + $transaction->total_amount,
                ]);

                UserProperty::create([
                    'rent_id' => $rent->id,
                    'user_id' => $rent->user_id,
                    'owner_id' => $rent->owner_id,
                    'property_id' => $rent->property_id,
                    'room_id' => $rent->room_id,
                    'period' => $rent->period,
                    'start_date' => $rent->start_date,
                    'end_date' => $rent->end_date,
                    'note' => $rent->note,
                    'amount' => $rent->amount,
                    'deposit_price' => $rent->deposit_price,
                    'total_amount' => $rent->total_amount,
                    'date' => date('Y-m-d'),
                    'status' => $rent->status,
                ]);
            } else if ($request->transaction_status == 'expire') {
                $transaction->update([
                    'status' => 'expired',
                    'active' => 0,
                ]);

                $rent->update([
                    'status' => 'Kadaluarsa',
                ]);
            } else {
                $transaction->update([
                    'status' => 'unpaid',
                ]);

                $rent->update([
                    'status' => 'Menunggu Pembayaran',
                ]);
            }
        }
    }
}
