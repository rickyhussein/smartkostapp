<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Rent;
use App\Models\User;
use App\Models\Transaction;
use App\Models\PropertyRoom;
use App\Models\UserProperty;
use Illuminate\Http\Request;
use App\Mail\ApprovalRentMail;
use App\Mail\UserTransactionMail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use App\Notifications\UserNotification;

class RentController extends Controller
{
    public function userRent()
    {
        $title = 'Pengajuan Sewa';
        $rents = Rent::where('user_id', auth()->user()->id)->orderBy('id', 'DESC')->paginate(10);

        return view('rents.userRent', compact(
            'title',
            'rents',
        ));
    }

    public function showUserRent($id)
    {
        $title = 'Pengajuan Sewa';
        $rent = Rent::find($id);
        $transaction = Transaction::where('rent_id', $rent->id)->where('active', 1)->first();

        return view('rents.showUserRent', compact(
            'title',
            'rent',
            'transaction',
        ));
    }

    public function ownerRent()
    {
        $title = 'Pengajuan Sewa';
        $rents = Rent::where('owner_id', auth()->user()->id)->orderBy('id', 'DESC')->paginate(10);

        return view('rents.ownerRent', compact(
            'title',
            'rents',
        ));
    }

    public function showOwnerRent($id)
    {
        $title = 'Pengajuan Sewa';
        $rent = Rent::find($id);

        return view('rents.showOwnerRent', compact(
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
                    'owner_fee' => $rent->owner_fee,
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
                        'gross_amount' => $transaction->total_amount,
                    ),
                    'callbacks' => array(
                        'finish' => url('/transaction/finish'),
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

                $user = User::find($rent->user_id);
                $message = 'Pengajuan sewa anda telah diapprove oleh ' . auth()->user()->name;
                $data = [
                    'user_id'   =>  auth()->user()->id,
                    'from'   =>  auth()->user()->name,
                    'message'   =>  $message,
                    'action'   =>  '/rents/user/show/'.$rent->id
                ];

                $user->notify(new UserNotification($data));

                Mail::to($user->email)->send(new ApprovalRentMail($rent));

                $whatsapp_api_url = config('midtrans.whatsapp_api_url');
                $whatsapp_api_session = config('midtrans.whatsapp_api_session');
                $whatsapp_api_key = config('midtrans.whatsapp_api_key');
    
                $property_name = $rent->property->name ?? '-';
                $room_name = $rent->room->room_name ?? '-';
                $room_type = $rent->room->room_type ?? '-';
                $room_height = $rent->room->room_height ?? '-';
                $room_width = $rent->room->room_width ?? '-';
                $heigh_width = $room_height . ' x ' . $room_width . " Meter";
    
                if ($rent->start_date) {
                    Carbon::setLocale('id');
                    $start_date = Carbon::createFromFormat('Y-m-d', $rent->start_date);
                    $new_start_date = $start_date->translatedFormat('d F Y');
                } else {
                    $new_start_date = '-';
                }
                
                if ($rent->end_date) {
                    Carbon::setLocale('id');
                    $end_date = Carbon::createFromFormat('Y-m-d', $rent->end_date);
                    $new_end_date = $end_date->translatedFormat('d F Y');
                } else {
                    $new_end_date = '-';
                }
    
                $message =  "Ini adalah pesan otomatis dari sistem layanan Smart Kost\n\n" .
                            "Salam sejahtera Bapak/Ibu, pengajuan sewa anda telah diapprove oleh owner kost :\n\n" .
                            "*PROPERTI YANG DISEWA* \n" .
                            "Nama Properti : " . $property_name . "\n" .
                            "Nama Kamar : " . $room_name . "\n" .
                            "Tipe Kamar : " . $room_type . "\n" .
                            "Ukuran Kamar : " . $heigh_width . "\n" .
                            "Periode Sewa : " . $rent->period . " Bulan \n" .
                            "Tanggal Mulai Sewa : " . $new_start_date . "\n" .
                            "Tanggal Selesai Sewa : " . $new_end_date . "\n\n" .
                            "*RINCIAN HARGA* \n" .
                            "Biaya Sewa : Rp " . number_format($rent->amount) . "\n" .
                            "Biaya Deposit : Rp " . number_format($rent->deposit_price) . "\n" .
                            "*Total : Rp " . number_format($rent->total_amount) . "* \n\n" .
    
                            "Silakan lakukan pembayaran melalui link berikut:\n\n" .
                            url('/rents/user/show/'.$rent->id);
    
                Http::get($whatsapp_api_url.'?session='.$whatsapp_api_session.'&to='.$user->whatsapp($user->phone_number).'&text='.$message.'&key='.$whatsapp_api_key);
            } else {
                $validated['status'] = 'Ditolak';
                $rent->update($validated);
                
                $user = User::find($rent->user_id);
                $message = 'Pengajuan sewa anda telah ditolak oleh ' . auth()->user()->name;
                $data = [
                    'user_id'   =>  auth()->user()->id,
                    'from'   =>  auth()->user()->name,
                    'message'   =>  $message,
                    'action'   =>  '/rents/user/show/'.$rent->id
                ];
            }
        });
        return redirect('/rents/owner/show/'.$rent->id)->with('success', 'Berhasil');
    }

    public function transactionCallback(Request $request)
    {
        $serverKey = config('midtrans.server_key');
        $hashed = hash('sha512', $request->order_id.$request->status_code.$request->gross_amount.$serverKey);
        if ($hashed == $request->signature_key) {
            $transaction = Transaction::find($request->order_id);
            if ($request->transaction_status == 'capture' || $request->transaction_status == 'settlement') {
                if ($transaction->up_id) {
                    $up = UserProperty::find($transaction->up_id);
                    $up->update([
                        'period' => $transaction->period,
                        'end_date' => $transaction->end_date,
                        'status' => 'Aktif',
                        'is_active' => 1,
                    ]);

                    $room = PropertyRoom::find($transaction->room_id);
                    $room->update([
                        'is_available' => 1,
                    ]);

                    $transaction->update([
                        'status' => 'paid',
                        'payment_source' => 'midtrans',
                        'payment_method' => $request->payment_type,
                        'paid_date' => $request->transaction_time,
                        'midtrans_transaction_id' => $request->transaction_id,
                        'active' => 0,
                    ]);
                } else {
                    $rent = Rent::find($transaction->rent_id);

                    $rent->update([
                        'status' => 'Pembayaran Berhasil',
                    ]);
    
                    $room = PropertyRoom::find($transaction->room_id);
                    $room->update([
                        'is_available' => 1,
                    ]);
    
                    $up = UserProperty::create([
                        'rent_id' => $rent->id,
                        'user_id' => $rent->user_id,
                        'owner_id' => $rent->owner_id,
                        'property_id' => $rent->property_id,
                        'room_id' => $rent->room_id,
                        'period' => $rent->period,
                        'start_date' => $rent->start_date,
                        'end_date' => $rent->end_date,
                        'note' => $rent->note,
                        'date' => date('Y-m-d'),
                        'is_active' => 1,
                        'status' => 'Tanda Tangan Kontrak',
                    ]);
    
                    $transaction->update([
                        'user_property_id' => $up->id,
                        'status' => 'paid',
                        'payment_source' => 'midtrans',
                        'payment_method' => $request->payment_type,
                        'paid_date' => $request->transaction_time,
                        'midtrans_transaction_id' => $request->transaction_id,
                        'active' => 0,
                    ]);
                }

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
                $action_user = '/user-properties/show/'.$transaction->up_id;

                $user = User::find($transaction->user_id);
                $data_user = [
                    'user_id'   =>  $transaction->user_id,
                    'from'   =>  $transaction->user->name,
                    'message'   =>  $message_user,
                    'action'   =>  $action_user
                ];

                $user->notify(new UserNotification($data_user));

                Mail::to($user->email)->send(new UserTransactionMail($transaction));
                
                $whatsapp_api_url = config('midtrans.whatsapp_api_url');
                $whatsapp_api_session = config('midtrans.whatsapp_api_session');
                $whatsapp_api_key = config('midtrans.whatsapp_api_key');
    
                $property_name = $transaction->property->name ?? '-';
                $room_name = $transaction->room->room_name ?? '-';
                $room_type = $transaction->room->room_type ?? '-';
                $room_height = $transaction->room->room_height ?? '-';
                $room_width = $transaction->room->room_width ?? '-';
                $heigh_width = $room_height . ' x ' . $room_width . " Meter";
    
                if ($transaction->start_date) {
                    Carbon::setLocale('id');
                    $start_date = Carbon::createFromFormat('Y-m-d', $transaction->start_date);
                    $new_start_date = $start_date->translatedFormat('d F Y');
                } else {
                    $new_start_date = '-';
                }
                
                if ($transaction->end_date) {
                    Carbon::setLocale('id');
                    $end_date = Carbon::createFromFormat('Y-m-d', $transaction->end_date);
                    $new_end_date = $end_date->translatedFormat('d F Y');
                } else {
                    $new_end_date = '-';
                }
    
                $message =  "Ini adalah pesan otomatis dari sistem layanan Smart Kost\n\n" .
                            "Terimakasih anda telah melakukan pembayaran sewa Kos " . ucwords(strtolower($property_name)) . " " . ucwords(strtolower($village_name)) . "\n\n" .
                            "*PROPERTI YANG DISEWA* \n" .
                            "Nama Properti : " . $property_name . "\n" .
                            "Nama Kamar : " . $room_name . "\n" .
                            "Tipe Kamar : " . $room_type . "\n" .
                            "Ukuran Kamar : " . $heigh_width . "\n" .
                            "Periode Sewa : " . $transaction->period . " Bulan \n" .
                            "Tanggal Mulai Sewa : " . $new_start_date . "\n" .
                            "Tanggal Selesai Sewa : " . $new_end_date . "\n\n" .
                            "*RINCIAN HARGA* \n" .
                            "Biaya Sewa : Rp " . number_format($transaction->amount) . "\n" .
                            "Biaya Deposit : Rp " . number_format($transaction->deposit_price) . "\n" .
                            "*Total : Rp " . number_format($transaction->total_amount) . "* \n\n" .
    
                            "Silahkan Tanda Tangan Kontrak Melalui Link Dibawah Ini :\n\n" .
                            url('/user-properties/show/'.$transaction->id);
    
                Http::get($whatsapp_api_url.'?session='.$whatsapp_api_session.'&to='.$user->whatsapp($user->phone_number).'&text='.$message.'&key='.$whatsapp_api_key);

                $message_owner = $transaction->user->name . ' berhasil melakukan pembayaran sewa Kos ' . ucwords(strtolower($property_name)) . ' ' .  ucwords(strtolower($village_name)) . ' sebesar Rp ' . number_format($transaction->total_amount);
                $action_owner = '/user-properties/owner/show/'.$transaction->up_id;

                $owner = User::find($transaction->owner_id);
                $data_owner = [
                    'user_id'   =>  $transaction->owner_id,
                    'from'   =>  $transaction->user->name,
                    'message'   =>  $message_owner,
                    'action'   =>  $action_owner
                ];

                $owner->notify(new UserNotification($data_owner));

                $owner->update([
                    'balance' => $owner->balance + $transaction->total_amount - $transaction->owner_fee,
                ]);
            } else if ($request->transaction_status == 'expire') {
                $transaction->update([
                    'status' => 'expire',
                    'active' => 0,
                ]);

                if (!$transaction->up_id) {
                    $rent = Rent::find($transaction->rent_id);
                    $rent->update([
                        'status' => 'Kadaluarsa',
                    ]);
                }
                
            } else if ($request->transaction_status == 'deny') {
                $transaction->update([
                    'status' => 'deny',
                    'active' => 0,
                ]);

                if (!$transaction->up_id) {
                    $rent = Rent::find($transaction->rent_id);
                    $rent->update([
                        'status' => 'Ditolak',
                    ]);
                }
            } else if ($request->transaction_status == 'cancel') {
                $transaction->update([
                    'status' => 'cancel',
                    'active' => 0,
                ]);

                if (!$transaction->up_id) {
                    $rent = Rent::find($transaction->rent_id);
                    $rent->update([
                        'status' => 'Dibatalkan',
                    ]);
                }
            } else if ($request->transaction_status == 'failure') {
                $transaction->update([
                    'status' => 'failure',
                    'active' => 0,
                ]);

                if (!$transaction->up_id) {
                    $rent = Rent::find($transaction->rent_id);
                    $rent->update([
                        'status' => 'Gagal',
                    ]);
                }
            } else {
                $transaction->update([
                    'status' => 'unpaid',
                ]);

                if (!$transaction->up_id) {
                    $rent = Rent::find($transaction->rent_id);
                    $rent->update([
                        'status' => 'Menunggu Pembayaran',
                    ]);
                }
            }
        }
    }
}
