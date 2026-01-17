<?php

namespace App\Http\Controllers;

use App\Models\Rent;
use App\Models\User;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
                $validated['status'] = 'Disetujui';
                $rent->update($validated);
                $user = User::find($rent->user_id);

                \Midtrans\Config::$serverKey = config('midtrans.server_key');
                \Midtrans\Config::$isProduction = config('midtrans.is_production');
                \Midtrans\Config::$isSanitized = true;
                \Midtrans\Config::$is3ds = true;

                $params = array(
                    'transaction_details' => array(
                        'order_id' => $rent->id,
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

                Transaction::create([
                    'rent_id' => $rent->id,
                    'user_id' => $rent->user_id,
                    'owner_id' => $rent->owner_id,
                    'property_id' => $rent->property_id,
                    'total_amount' => $rent->total_amount,
                    'active' => 1,
                    'date' => date('Y-m-d'),
                    'in_out' => 'in',
                    'month' => date('m'),
                    'year' => date('Y'),
                    'status' => 'Menunggu Pembayaran',
                    'created_by' => auth()->user()->id,
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
            if ($request->transaction_status == 'capture' || $request->transaction_status == 'settlement') {
                $transaction->update([
                    'status' => 'Pembayaran Berhasil',
                    'payment_source' => 'midtrans',
                    'payment_method' => $request->payment_type,
                    'paid_date' => $request->transaction_time,
                    'midtrans_transaction_id' => $request->transaction_id,
                    'active' => 0,
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
                $action_user = '/rent-user/show/'.$transaction->rent_id;

                $user = User::find($transaction->user_id);
                $data_user = [
                    'user_id'   =>  $transaction->user_id,
                    'from'   =>  $transaction->user->name,
                    'message'   =>  $message_user,
                    'action'   =>  $action_user
                ];

                $user->notify(new UserNotification($data_user));

                $message_owner = auth()->user()->name . ' berhasil melakukan pembayaran sewa Kos ' . ucwords(strtolower($property_name)) . ' ' .  ucwords(strtolower($village_name)) . ' sebesar Rp ' . number_format($transaction->total_amount);
                $action_owner = '/rent-owner/show/'.$transaction->rent_id;

                $owner = User::find($transaction->owner_id);
                $data_owner = [
                    'user_id'   =>  $transaction->owner_id,
                    'from'   =>  $transaction->user->name,
                    'message'   =>  $message_owner,
                    'action'   =>  $action_owner
                ];

                $owner->notify(new UserNotification($data_owner));
            } else if ($request->transaction_status == 'pending') {
                $transaction->update([
                    'status' => 'Menunggu Pembayaran',
                ]);
            } else if ($request->transaction_status == 'expire') {
                $transaction->update([
                    'status' => 'Expired',
                    'active' => 0,
                ]);
            } else {
                $transaction->update([
                    'status' => $request->transaction_status,
                ]);
            }
        }
    }
}
