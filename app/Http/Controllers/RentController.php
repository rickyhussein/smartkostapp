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
                        'finish' => url('/transactions/user/finish'),
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
}
