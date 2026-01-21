<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use App\Models\Transaction;
use App\Models\UserProperty;
use Illuminate\Http\Request;

class HistoryController extends Controller
{
    public function userHistory()
    {
        $title = 'Histori Properti';
        $search = request()->input('search');

        $user_properties = UserProperty::where('user_id', auth()->user()->id)
        ->when($search, function ($query) use ($search) {
            $query->where(function ($subquery) use ($search) {
                $subquery->whereHas('property', function ($q) use ($search) {
                    $q->where('name', 'LIKE', '%' . $search . '%')
                    ->orWhere('category', 'LIKE', '%' . $search . '%');
                })
                ->orWhereHas('room', function ($q) use ($search) {
                    $q->where('room_name', 'LIKE', '%' . $search . '%')
                    ->orWhere('room_type', 'LIKE', '%' . $search . '%');
                });
            });

        })
        ->orderBy('id', 'DESC')
        ->paginate(10);

        return view('history.userHistory', compact(
            'title',
            'user_properties',
        ));
    }

    public function showUserHistory($id)
    {
        $title = 'Properti Saya';
        $up = UserProperty::find($id);
        $property = $up->property;
        $room = $up->room;
        $rent = $up->rent;
        $complaints = Complaint::where('user_property_id', $up->id)->get();
        $transactions = Transaction::where('user_property_id', $up->id)
        ->where(function ($query) {
            $query->where('status', 'paid')
            ->orWhere('status', 'unpaid');
        })
        ->get();

        return view('history.showUserHistory', compact(
            'title',
            'up',
            'property',
            'room',
            'rent',
            'complaints',
            'transactions',
        ));
    }
}
