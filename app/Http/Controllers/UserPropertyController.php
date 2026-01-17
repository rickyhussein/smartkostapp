<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\UserProperty;
use Illuminate\Http\Request;

class UserPropertyController extends Controller
{
    public function index()
    {
        $title = 'Properti Saya';
        $user_properties = UserProperty::where('user_id', auth()->user()->id)->where('is_active', 1)->orderBy('id', 'DESC')->paginate(10);

        return view('user-properies.index', compact(
            'title',
            'user_properties',
        ));

    }
    
    public function show($id)
    {
        $title = 'Properti Saya';
        $up = UserProperty::find($id);
        $transactions = Transaction::where('user_property_id', $up->id)->get();

        return view('user-properies.show', compact(
            'title',
            'up',
            'transactions',
        ));
    }
}
