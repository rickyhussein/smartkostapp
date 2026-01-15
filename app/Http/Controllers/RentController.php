<?php

namespace App\Http\Controllers;

use App\Models\Rent;
use Illuminate\Http\Request;

class RentController extends Controller
{
    public function showUserRent($id)
    {
        $title = 'Pengajuan Sewa';
        $rent = Rent::find($id);
        $transaction = null;

        return view('rent.showUserRent', compact(
            'title',
            'rent',
            'transaction',
        ));
    }
}
