<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Rent;
use App\Models\User;
use App\Models\Transaction;
use App\Models\PropertyRoom;
use App\Models\UserProperty;
use Illuminate\Http\Request;
use App\Mail\UserTransactionMail;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use App\Notifications\UserNotification;

class TransactionController extends Controller
{
    public function userTransactions()
    {
        $title = 'Transaksi';
        $search = request()->input('search');

        $transactions = Transaction::where('user_id', auth()->user()->id)
        ->when($search, function ($query) use ($search) {
            $query->where(function ($subquery) use ($search) {
                $subquery->where('status', 'LIKE', '%' . $search . '%')
                ->orWhereHas('property', function ($q) use ($search) {
                    $q->where('name', 'LIKE', '%' . $search . '%');
                })
                ->orWhereHas('room', function ($q) use ($search) {
                    $q->where('room_name', 'LIKE', '%' . $search . '%');
                });
            });
        })
        ->orderBy('id', 'DESC')
        ->paginate(10)
        ->withQueryString();

        return view('transactions.userTransactions' , compact(
            'title',
            'transactions',
        ));
    }

    public function showUserTransactions($id)
    {
        $title = 'Transaksi';
        $transaction = Transaction::find($id);

        return view('transactions.showUserTransactions' , compact(
            'title',
            'transaction',
        ));
    }

    public function finishUserTransactions()
    {
        $transaction = Transaction::find(request('order_id'));
        $transaction_status = request('transaction_status');
        $title = $transaction_status;

        return view('transactions.finishUserTransactions' , compact(
            'title',
            'transaction',
            'transaction_status',
        ));
    }

    public function callback(Request $request)
    {
        $serverKey = config('midtrans.server_key');
        $hashed = hash('sha512', $request->order_id.$request->status_code.$request->gross_amount.$serverKey);
        if ($hashed == $request->signature_key) {
            $transaction = Transaction::find($request->order_id);
            if ($request->transaction_status == 'capture' || $request->transaction_status == 'settlement') {
                if ($transaction->user_property_id) {
                    $up = UserProperty::find($transaction->user_property_id);
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
                        'midtrans_status' => $request->transaction_status,
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
                        'status' => 'Aktif',
                    ]);
    
                    $transaction->update([
                        'user_property_id' => $up->id,
                        'midtrans_status' => $request->transaction_status,
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
                $action_user = '/user-properties/show/'.$transaction->user_property_id;

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
                $action_owner = '/user-properties/owner/show/'.$transaction->user_property_id;

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
                    'midtrans_status' => $request->transaction_status,
                    'status' => 'expire',
                    'active' => 0,
                ]);

                if (!$transaction->user_property_id) {
                    $rent = Rent::find($transaction->rent_id);
                    $rent->update([
                        'status' => 'Kadaluarsa',
                    ]);
                }
                
            } else if ($request->transaction_status == 'deny') {
                $transaction->update([
                    'midtrans_status' => $request->transaction_status,
                    'status' => 'deny',
                    'active' => 0,
                ]);

                if (!$transaction->user_property_id) {
                    $rent = Rent::find($transaction->rent_id);
                    $rent->update([
                        'status' => 'Ditolak',
                    ]);
                }
            } else if ($request->transaction_status == 'cancel') {
                $transaction->update([
                    'midtrans_status' => $request->transaction_status,
                    'status' => 'cancel',
                    'active' => 0,
                ]);

                if (!$transaction->user_property_id) {
                    $rent = Rent::find($transaction->rent_id);
                    $rent->update([
                        'status' => 'Dibatalkan',
                    ]);
                }
            } else if ($request->transaction_status == 'failure') {
                $transaction->update([
                    'midtrans_status' => $request->transaction_status,
                    'status' => 'failure',
                    'active' => 0,
                ]);

                if (!$transaction->user_property_id) {
                    $rent = Rent::find($transaction->rent_id);
                    $rent->update([
                        'status' => 'Gagal',
                    ]);
                }
            } else {
                $transaction->update([
                    'midtrans_status' => $request->transaction_status,
                    'status' => 'unpaid',
                ]);

                if (!$transaction->user_property_id) {
                    $rent = Rent::find($transaction->rent_id);
                    $rent->update([
                        'status' => 'Menunggu Pembayaran',
                    ]);
                }
            }
        }
    }
}
