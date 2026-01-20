<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\UserProperty;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class UserPropertyController extends Controller
{
    public function index()
    {
        $title = 'Properti Saya';
        $user_properties = UserProperty::where('user_id', auth()->user()->id)->where('is_active', 1)->orderBy('id', 'DESC')->paginate(10);

        return view('user-properties.index', compact(
            'title',
            'user_properties',
        ));

    }
    
    public function show($id)
    {
        $title = 'Properti Saya';
        $up = UserProperty::find($id);
        $property = $up->property;
        $room = $up->room;
        $rent = $up->rent;
        $transactions = Transaction::where('user_property_id', $up->id)
        ->delete();
        $up->delete();
        $up_start_date = date('Y-m-d', strtotime($up->end_date . ' +1 day'));

        return view('user-properties.show', compact(
            'title',
            'up',
            'property',
            'room',
            'rent',
            'transactions',
            'up_start_date',
        ));
    }

    public function signature(Request $request, $id)
    {
        $up = UserProperty::find($id);
        $signature = $request->signature;
        $image_parts = explode(";base64,", $signature);
        $image_base64 = base64_decode($image_parts[1]);
        $fileName = 'signature/'.$up->id.'.png';

        Storage::disk('public')->put($fileName, $image_base64);

        $up->update([
            'signature' => $fileName,
            'signature_date' => date('Y-m-d'),
        ]);

        return response()->json(['success' => true]);
    }

    public function contract($id)
    {
        $up = UserProperty::find($id);
        $number = str_pad($up->id, 4, '0', STR_PAD_LEFT);
        $filename = 'CONTRACT-'.$number.'.pdf';

        $pdf = Pdf::loadView('user-properties.contract', [
            'up' => $up,
            'filename' => $filename,
        ]);

        return $pdf->stream($filename);
    }
    
    public function cancel($transaction_id)
    {
        $transaction = Transaction::find($transaction_id);
        DB::transaction(function ()  use ($transaction) {
            $transaction->update([
                'status' => 'cancel',
                'active' => 0,
            ]);
        });
        return redirect('/user-properties/show/'.$transaction->user_property_id)->with('success', 'Transaksi Berhasil Dibatalkan');
    }

    public function extend(Request $request, $id)
    {
        $up = UserProperty::find($id);
        DB::transaction(function ()  use ($request, $up) {
            $validated = $request->validate([
                'period' => 'required',
                'start_date' => 'required',
                'end_date' => 'required',
            ]);

            $room = $up->room;
            $user = $up->user;

            if ($validated["period"] == 1) {
                $amount = $room->one_month_price;
            } else if ($validated["period"] == 3) {
                $amount = $room->three_month_price;
            } else if ($validated["period"] == 6) {
                $amount = $room->six_month_price;
            } else {
                $amount = $room->twelve_month_price;
            }

            $transaction = Transaction::create([
                'user_property_id' => $up->id,
                'rent_id' => $up->rent_id,
                'user_id' => $up->user_id,
                'owner_id' => $up->owner_id,
                'room_id' => $up->room_id,
                'property_id' => $up->property_id,
                'amount' => $amount,
                'deposit_price' => 0,
                'total_amount' => $amount,
                'owner_fee' => 5000,
                'start_date' => $validated['start_date'],
                'end_date' => $validated['end_date'],
                'period' => $validated['period'],
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
        });

        return redirect('/user-properties/show/'.$up->id)->with('success', 'Data Berhasil Disimpan');
    }

    public function ownerUp()
    {
        $title = 'Kamar Terisi';
        $user_properties = UserProperty::where('owner_id', auth()->user()->id)->where('is_active', 1)->orderBy('id', 'DESC')->paginate(10);

        return view('user-properties.ownerUp', compact(
            'title',
            'user_properties',
        ));

    }

    public function showOwnerUp($id)
    {
        $title = 'Kamar Terisi';
        $up = UserProperty::find($id);
        $property = $up->property;
        $room = $up->room;
        $rent = $up->rent;
        $transactions = Transaction::where('user_property_id', $up->id)->get();
        $up_start_date = date('Y-m-d', strtotime($up->end_date . ' +1 day'));

        return view('user-properties.showOwnerUp', compact(
            'title',
            'up',
            'property',
            'room',
            'rent',
            'transactions',
            'up_start_date',
        ));
    }

    public function printContractOwnerUp($id)
    {
        $up = UserProperty::find($id);
        $number = str_pad($up->id, 4, '0', STR_PAD_LEFT);
        $filename = 'CONTRACT-'.$number.'.pdf';

        $pdf = Pdf::loadView('user-properties.contract', [
            'up' => $up,
            'filename' => $filename,
        ]);

        return $pdf->stream($filename);
    }

    public function editContractOwnerUp($id)
    {
        $title = 'Edit Kontrak';
        $up = UserProperty::find($id);
        $property = $up->property;
        $room = $up->room;
        $rent = $up->rent;

        return view('user-properties.editContractOwnerUp', compact(
            'title',
            'up',
            'property',
            'room',
            'rent',
        ));
    }

    public function updateContractOwnerUp(Request $request, $id)
    {
        $up = UserProperty::find($id);

        DB::transaction(function ()  use ($request, $up) {
            $validated = $request->validate([
                'edit_contract' => 'nullable',
                'contract' => 'nullable',
            ]);

            $validated['edit_contract'] = $request->edit_contract ? $request->edit_contract : null;
            $validated['status'] = 'Aktif';
            $up->update($validated);
        });

        return redirect('/user-properties/owner/show/'.$up->id)->with('success', 'Data Berhasil Disimpan');
    }
}
