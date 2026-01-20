<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use Illuminate\Http\Request;

class ComplaintController extends Controller
{
    public function ownerComplaint()
    {
        $title = 'Keluhan';
        $search = request()->input('search');

        $complaints = Complaint::where('owner_id', auth()->user()->id)
        ->when($search, function ($query) use ($search) {
            $query->where('complaint', 'LIKE', '%' . $search . '%')
            ->orWhere('type', 'LIKE', '%' . $search . '%');
        })
        ->orderBy('id', 'DESC')
        ->paginate(10)
        ->withQueryString();

        return view('complaints.ownerComplaint', compact(
            'title',
            'complaints',
        ));
    }
}
