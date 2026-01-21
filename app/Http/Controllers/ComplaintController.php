<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ComplaintController extends Controller
{
    public function ownerComplaint()
    {
        $title = 'Keluhan';
        $search = request()->input('search');

        $complaints = Complaint::where('owner_id', auth()->user()->id)
        ->when($search, function ($query) use ($search) {
            $query->where('complaint', 'LIKE', '%' . $search . '%')
            ->orWhere('type', 'LIKE', '%' . $search . '%')
            ->orWhere('status', 'LIKE', '%' . $search . '%')
            ->orWhereHas('user', function ($q) use ($search) {
                $q->where('name', 'LIKE', '%' . $search . '%');
            })
            ->orWhereHas('property', function ($q) use ($search) {
                $q->where('name', 'LIKE', '%' . $search . '%');
            })
            ->orWhereHas('room', function ($q) use ($search) {
                $q->where('room_name', 'LIKE', '%' . $search . '%');
            });
        })
        ->orderBy('id', 'DESC')
        ->paginate(10)
        ->withQueryString();

        return view('complaints.ownerComplaint', compact(
            'title',
            'complaints',
        ));
    }

    public function showOwnerComplaint($id)
    {
        $title = 'Keluhan';
        $complaint = Complaint::find($id);

        return view('complaints.showOwnerComplaint', compact(
            'title',
            'complaint',
        ));
    }

    public function approvalOwnerComplaint(Request $request, $id)
    {
        $complaint = Complaint::find($id);
        DB::transaction(function ()  use ($request, $complaint) {
            $validated = $request->validate([
                'status' => 'required',
                'solved_date' => 'required',
                'owner_note' => 'nullable',
            ]);

            $complaint->update($validated);
        });

        return redirect('/complaints/owner/show/'.$complaint->id)->with('success', 'Data Berhasil Diupdate.');
    }
}
