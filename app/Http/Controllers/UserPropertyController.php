<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\UserProperty;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

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
        $transactions = Transaction::where('user_property_id', $up->id)->get();
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

    public function contract( $id)
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
        $title = 'Properti Saya';
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
}
