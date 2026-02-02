<?php

namespace App\Http\Controllers;

use App\Models\PropertyRoom;
use Illuminate\Http\Request;

class PropertyRoomController extends Controller
{
    public function ownerPropertyRoom()
    {
        $title = 'Kamar Terisi';
        $search = request()->input('search');

        $property_rooms = PropertyRoom::select('property_rooms.*')
        ->join('properties', 'properties.id', '=', 'property_rooms.property_id')
        ->where('properties.user_id', auth()->user()->id)
        ->whereNull('is_available')
        ->when($search, function ($query) use ($search) {
            $query->where(function ($subquery) use ($search) {
                $subquery->where('room_name', 'LIKE', '%' . $search . '%')
                ->orWhere('room_type', 'LIKE', '%' . $search . '%')
                ->orWhereHas('property', function ($q) use ($search) {
                    $q->where('name', 'LIKE', '%' . $search . '%')
                    ->orWhere('category', 'LIKE', '%' . $search . '%');
                });
            });

        })
        ->orderBy('id', 'DESC')
        ->paginate(10);

        return view('property-room.ownerPropertyRoom', compact(
            'title',
            'property_rooms',
        ));
    }
}
