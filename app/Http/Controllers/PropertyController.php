<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\User;
use App\Models\Village;
use App\Models\District;
use App\Models\Facility;
use App\Models\Property;
use App\Models\Province;
use App\Models\Regulation;
use App\Models\PropertyRoom;
use Illuminate\Http\Request;
use App\Models\PropertyPhoto;
use App\Models\PropertyFacility;
use App\Models\PropertyRoomPhoto;
use App\Models\PropertyRegulation;
use Illuminate\Support\Facades\DB;
use App\Notifications\UserNotification;

class PropertyController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:properti_admin', ['only' => ['index']]);
        $this->middleware('permission:properti_owner', ['only' => ['ownerProperties']]);
    }

    public function index()
    {
        $title = 'Properti';
        $search = request()->input('search');

        $properties = Property::when($search, function ($query) use ($search) {
            $query->where('name', 'LIKE', '%' . $search . '%')
            ->orWhere('category', 'LIKE', '%' . $search . '%')
            ->orWhere('address', 'LIKE', '%' . $search . '%')
            ->orWhereHas('user', function ($q) use ($search) {
                $q->where('name', 'LIKE', '%' . $search . '%');
            });
        })
        ->orderBy('id', 'DESC')
        ->paginate(10)
        ->withQueryString();

        return view('properties.index', compact(
            'title',
            'properties',
        ));
    }

    public function show($id)
    {
        $title = 'Properti';
        $property = Property::find($id);

        return view('properties.show', compact(
            'title',
            'property',
        ));
    }

    public function approve(Request $request, $id)
    {
        $property = Property::find($id);
        DB::transaction(function ()  use ($request, $property) {
            $validated = $request->validate([
                'admin_notes' => 'nullable'
            ]);

            $validated['status'] = 'Disetujui';
            $property->update($validated);

            $user = User::find($property->user_id);

            $message = 'Permintaan penambahan property anda telah disetujui oleh admin';

            $data = [
                'user_id'   =>  auth()->user()->id,
                'from'   =>  auth()->user()->name,
                'message'   =>  $message,
                'action'   =>  '/properties/owner/show/'.$property->id
            ];

            $user->notify(new UserNotification($data));
        });

        return redirect('/properties/show/'.$property->id)->with('success', 'Property Telah Disetujui');
    }

    public function reject(Request $request, $id)
    {
        $property = Property::find($id);
        DB::transaction(function ()  use ($request, $property) {
            $validated = $request->validate([
                'admin_notes' => 'nullable'
            ]);

            $validated['status'] = 'Ditolak';

            $user = User::find($property->user_id);
            $property->update($validated);

            $message = 'Permintaan penambahan property anda telah ditolak oleh admin';

            $data = [
                'user_id'   =>  auth()->user()->id,
                'from'   =>  auth()->user()->name,
                'message'   =>  $message,
                'action'   =>  '/properties/owner/show/'.$property->id
            ];

            $user->notify(new UserNotification($data));
        });

        return redirect('/properties/show/'.$property->id)->with('success', 'Property Telah Ditolak');
    }

    public function ownerProperties()
    {
        $title = 'Kelola Properti';
        $search = request()->input('search');

        $properties = Property::where('user_id', auth()->user()->id)
        ->when($search, function ($query) use ($search) {
            $query->where('name', 'LIKE', '%' . $search . '%')
            ->orWhere('category', 'LIKE', '%' . $search . '%')
            ->orWhere('address', 'LIKE', '%' . $search . '%');
        })
        ->orderBy('id', 'DESC')
        ->paginate(10)
        ->withQueryString();

        return view('properties.ownerProperties', compact(
            'title',
            'properties',
        ));
    }

    public function createOwnerProperties()
    {
        $title = 'Kelola Properti';
        $regulations = Regulation::orderBy('name')->get();
        $facilities = Facility::orderBy('name')->get();
        $provinces = Province::orderBy('name')->get();
        $cities = old('province_id') ? City::where('province_id', old('province_id'))->orderBy('name')->get() : [];
        $districts = old('city_id') ? District::where('city_id', old('city_id'))->orderBy('name')->get() : [];
        $villages = old('district_id') ? Village::where('district_id', old('district_id'))->orderBy('name')->get() : [];

        return view('properties.createOwnerProperties', compact(
            'title',
            'regulations',
            'facilities',
            'provinces',
            'cities',
            'districts',
            'villages',
        ));
    }

    public function storeOwnerProperties(Request $request)
    {
        $result = null;
        DB::transaction(function ()  use ($request, $result) {
            $validated = $request->validate([
                'name' => 'required',
                'category' => 'required',
                'description' => 'nullable',
                'admin_name' => 'required',
                'admin_number' => 'required',
                'address' => 'required',
                'province_id' => 'required',
                'city_id' => 'required',
                'district_id' => 'required',
                'village_id' => 'required',
                'latitude' => 'nullable',
                'longitude' => 'nullable',
                'regulation_file_path' => 'nullable',
                'video_file_path' => 'nullable',
                'screenshot_video' => 'nullable',
            ]);

            if ($request->file('regulation_file_path')) {
                $validated['regulation_file_path'] = $request->file('regulation_file_path')->store('regulation_file_path');
                $validated['regulation_file_name'] = $request->file('regulation_file_path')->getClientOriginalName();
            }

            if ($request->file('video_file_path')) {
                $validated['video_file_path'] = $request->file('video_file_path')->store('video_file_path');
                $validated['video_file_name'] = $request->file('video_file_path')->getClientOriginalName();
            }

            if ($request->file('screenshot_video')) {
                $validated['screenshot_video'] = $request->file('screenshot_video')->store('screenshot_video');
            }

            $validated['date'] = date('Y-m-d');
            $validated['user_id'] = auth()->user()->id;
            $validated['created_by'] = auth()->user()->id;
            $validated['status'] = 'Menunggu Persetujuan Admin';
            $validated['count_click'] = 0;

            $property = Property::create($validated);
            $this->result = $property->id;

            $facility_id = $request->input('facility_id', []);

            for ($i = 0; $i < count($facility_id); $i++) {
                if (!empty($facility_id[$i])) {
                    PropertyFacility::create([
                        'property_id' => $property->id,
                        'facility_id' => $facility_id[$i],
                    ]);
                }
            }

            $regulation_id = $request->input('regulation_id', []);

            for ($i = 0; $i < count($regulation_id); $i++) {
                if (!empty($regulation_id[$i])) {
                    PropertyRegulation::create([
                        'property_id' => $property->id,
                        'regulation_id' => $regulation_id[$i],
                    ]);
                }
            }

            $property_files  = $request->file('property_file_path', []);

            for ($i = 0; $i < count($property_files); $i++) {
                if (!empty($property_files[$i])) {
                    $property_file_path = null;
                    $property_file_name = null;

                    if (isset($property_files[$i]) && $property_files[$i]->isValid()) {
                        $property_file_path = $property_files[$i]->store('property_file_path');
                        $property_file_name = $property_files[$i]->getClientOriginalName();
                    }

                    PropertyPhoto::create([
                        'property_id' => $property->id,
                        'property_file_path' => $property_file_path,
                        'property_file_name' => $property_file_name,
                    ]);
                }
            }

            $room_name = $request->input('room_name', []);
            $room_type = $request->input('room_type', []);
            $floor = $request->input('floor', []);
            $room_height = $request->input('room_height', []);
            $room_width = $request->input('room_width', []);
            $one_month_price = $request->input('one_month_price', []);
            $three_month_price = $request->input('three_month_price', []);
            $six_month_price = $request->input('six_month_price', []);
            $twelve_month_price = $request->input('twelve_month_price', []);
            $deposit_price = $request->input('deposit_price', []);
            $is_available = $request->input('is_available', []);
            $room_files  = $request->file('room_file_path', []);

            for ($i = 0; $i < count($room_name); $i++) {
                if (!empty($room_name[$i])) {
                    $room_file_path = null;
                    $room_file_name = null;

                    if (isset($room_files[$i]) && $room_files[$i]->isValid()) {
                        $room_file_path = $room_files[$i]->store('room_file_path');
                        $room_file_name = $room_files[$i]->getClientOriginalName();
                    }

                    PropertyRoom::create([
                        'property_id' => $property->id,
                        'room_name' => $room_name[$i],
                        'room_type' => $room_type[$i],
                        'floor' => $floor[$i],
                        'room_height' => $room_height[$i],
                        'room_width' => $room_width[$i],
                        'one_month_price' => $one_month_price[$i] ? str_replace(',', '', $one_month_price[$i]) : 0,
                        'three_month_price' => $three_month_price[$i] ? str_replace(',', '', $three_month_price[$i]) : 0,
                        'six_month_price' => $six_month_price[$i] ? str_replace(',', '', $six_month_price[$i]) : 0,
                        'twelve_month_price' => $twelve_month_price[$i] ? str_replace(',', '', $twelve_month_price[$i]) : 0,
                        'deposit_price' => $deposit_price[$i] ? str_replace(',', '', $deposit_price[$i]) : 0,
                        'is_available' => $is_available[$i],
                        'room_file_path' => $room_file_path,
                        'room_file_name' => $room_file_name,
                    ]);
                }
            }

            $message = 'Permintaan penambahan properti oleh ' . auth()->user()->name . ' membutuhkan persetujuan dari anda.';

            $users = User::whereHas('roles', function ($query) {
                $query->where('name', 'admin');
            })->get();

            foreach ($users as $user) {
                $data = [
                    'user_id'   =>  auth()->user()->id,
                    'from'   =>  auth()->user()->name,
                    'message'   =>  $message,
                    'action'   =>  '/properties/show/'.$property->id
                ];

                $user->notify(new UserNotification($data));
            }
        });

        return redirect('/properties/owner/show/'.$this->result)->with('success', 'Data Berhasil Ditambahkan');
    }

    public function editOwnerProperties($id)
    {
        $title = 'Kelola Properti';
        $property = Property::find($id);
        $regulations = Regulation::orderBy('name')->get();
        $facilities = Facility::orderBy('name')->get();
        $provinces = Province::orderBy('name')->get();
        $cities = old('province_id', $property->province_id) ? City::where('province_id', old('province_id', $property->province_id))->orderBy('name')->get() : [];
        $districts = old('city_id', $property->city_id) ? District::where('city_id', old('city_id', $property->city_id))->orderBy('name')->get() : [];
        $villages = old('district_id', $property->district_id) ? Village::where('district_id', old('district_id', $property->district_id))->orderBy('name')->get() : [];
        $facilitiy_id = PropertyFacility::where('property_id', $property->id)->pluck('facility_id')->toArray();
        $regulation_id = PropertyRegulation::where('property_id', $property->id)->pluck('regulation_id')->toArray();

        return view('properties.editOwnerProperties', compact(
            'title',
            'property',
            'regulations',
            'facilities',
            'provinces',
            'cities',
            'districts',
            'villages',
            'facilitiy_id',
            'regulation_id',
        ));
    }

    public function updateOwnerProperties(Request $request, $id)
    {
        $property = Property::find($id);
        DB::transaction(function ()  use ($request, $property) {
            $validated = $request->validate([
                'name' => 'required',
                'category' => 'required',
                'description' => 'nullable',
                'admin_name' => 'required',
                'admin_number' => 'required',
                'address' => 'required',
                'province_id' => 'required',
                'city_id' => 'required',
                'district_id' => 'required',
                'village_id' => 'required',
                'latitude' => 'nullable',
                'longitude' => 'nullable',
                'regulation_file_path' => 'nullable',
                'video_file_path' => 'nullable',
                'screenshot_video' => 'nullable',
            ]);

            if ($request->file('regulation_file_path')) {
                $validated['regulation_file_path'] = $request->file('regulation_file_path')->store('regulation_file_path');
                $validated['regulation_file_name'] = $request->file('regulation_file_path')->getClientOriginalName();
            }

            if ($request->file('video_file_path')) {
                $validated['video_file_path'] = $request->file('video_file_path')->store('video_file_path');
                $validated['video_file_name'] = $request->file('video_file_path')->getClientOriginalName();
            }

            if ($request->file('screenshot_video')) {
                $validated['screenshot_video'] = $request->file('screenshot_video')->store('screenshot_video');
            }

            $validated['status'] = 'Menunggu Persetujuan Admin';
            $validated['updated_by'] = auth()->user()->id;

            $property->update($validated);

            $facility_id = $request->input('facility_id', []);
            PropertyFacility::where('property_id', $property->id)->delete();
            for ($i = 0; $i < count($facility_id); $i++) {
                if (!empty($facility_id[$i])) {
                    PropertyFacility::create([
                        'property_id' => $property->id,
                        'facility_id' => $facility_id[$i],
                    ]);
                }
            }

            $regulation_id = $request->input('regulation_id', []);
            PropertyRegulation::where('property_id', $property->id)->delete();
            for ($i = 0; $i < count($regulation_id); $i++) {
                if (!empty($regulation_id[$i])) {
                    PropertyRegulation::create([
                        'property_id' => $property->id,
                        'regulation_id' => $regulation_id[$i],
                    ]);
                }
            }

            $old_property_file_path = $request->input('old_property_file_path', []);
            $old_property_file_name = $request->input('old_property_file_name', []);
            $property_file_path = $request->file('property_file_path', []);

            PropertyPhoto::where('property_id', $property->id)->delete();

            $all_photos = array_unique(array_merge(
                array_keys($old_property_file_path),
                array_keys($property_file_path)
            ));

            foreach ($all_photos as $ap) {
                if (isset($property_file_path[$ap]) && $property_file_path[$ap] && $property_file_path[$ap]->isValid()) {
                    $pfp = $property_file_path[$ap]->store('property_file_path');
                    $pfn = $property_file_path[$ap]->getClientOriginalName();
                } elseif (!empty($old_property_file_path[$ap]) && !empty($old_property_file_name[$ap])) {
                    $pfp = $old_property_file_path[$ap];
                    $pfn = $old_property_file_name[$ap];
                } else {
                    continue;
                }

                PropertyPhoto::create([
                    'property_id' => $property->id,
                    'property_file_path' => $pfp,
                    'property_file_name' => $pfn,
                ]);
            }

            $room_name = $request->input('room_name', []);
            $room_type = $request->input('room_type', []);
            $floor = $request->input('floor', []);
            $room_height = $request->input('room_height', []);
            $room_width = $request->input('room_width', []);
            $one_month_price = $request->input('one_month_price', []);
            $three_month_price = $request->input('three_month_price', []);
            $six_month_price = $request->input('six_month_price', []);
            $twelve_month_price = $request->input('twelve_month_price', []);
            $deposit_price = $request->input('deposit_price', []);
            $is_available = $request->input('is_available', []);

            $old_room_file_path = $request->input('old_room_file_path', []);
            $old_room_file_name = $request->input('old_room_file_name', []);
            $old_room_id = $request->input('old_room_id', []);
            $room_file_path  = $request->file('room_file_path', []);

            $all_rooms = array_unique(array_merge(
                array_keys($old_room_file_path),
                array_keys($room_file_path)
            ));

            PropertyRoom::where('property_id', $property->id)->whereNotIn('id', $old_room_id)->delete();

            foreach ($all_rooms as $ar) {
                if (isset($room_file_path[$ar]) && $room_file_path[$ar] && $room_file_path[$ar]->isValid()) {
                    $rfp = $room_file_path[$ar]->store('room_file_path');
                    $rfn = $room_file_path[$ar]->getClientOriginalName();
                } elseif (!empty($old_room_file_path[$ar]) && !empty($old_room_file_name[$ar])) {
                    $rfp = $old_room_file_path[$ar];
                    $rfn = $old_room_file_name[$ar];
                } else {
                    continue;
                }

                $room_photos = PropertyRoomPhoto::where('room_id', $old_room_id[$ar])->get();

                $room = PropertyRoom::create([
                    'property_id' => $property->id,
                    'room_name' => $room_name[$ar],
                    'room_type' => $room_type[$ar],
                    'floor' => $floor[$ar],
                    'room_height' => $room_height[$ar],
                    'room_width' => $room_width[$ar],
                    'one_month_price' => $one_month_price[$ar] ? str_replace(',', '', $one_month_price[$ar]) : 0,
                    'three_month_price' => $three_month_price[$ar] ? str_replace(',', '', $three_month_price[$ar]) : 0,
                    'six_month_price' => $six_month_price[$ar] ? str_replace(',', '', $six_month_price[$ar]) : 0,
                    'twelve_month_price' => $twelve_month_price[$ar] ? str_replace(',', '', $twelve_month_price[$ar]) : 0,
                    'deposit_price' => $deposit_price[$ar] ? str_replace(',', '', $deposit_price[$ar]) : 0,
                    'is_available' => $is_available[$ar],
                    'room_file_path' => $rfp,
                    'room_file_name' => $rfn,
                ]);

                foreach($room_photos as $rp) {
                    $rp->update([
                        'room_id' => $room->id
                    ]);
                }

                PropertyRoom::where('id', $old_room_id[$ar])->delete();
            }

            $message = 'Permintaan penambahan properti oleh ' . auth()->user()->name . ' membutuhkan persetujuan dari anda.';

            $users = User::whereHas('roles', function ($query) {
                $query->where('name', 'admin');
            })->get();

            foreach ($users as $user) {
                $data = [
                    'user_id'   =>  auth()->user()->id,
                    'from'   =>  auth()->user()->name,
                    'message'   =>  $message,
                    'action'   =>  '/properties/show/'.$property->id
                ];

                $user->notify(new UserNotification($data));
            }
        });

        return redirect('/properties/owner/show/'.$property->id)->with('success', 'Data Berhasil Diubah');
    }

    public function showOwnerProperties($id)
    {
        $property = Property::find($id);
        $title = $property->name ? ucwords(strtolower($property->name)) : '';

        return view('properties.showOwnerProperties', compact(
            'title',
            'property',
        ));
    }

    public function showRoomOwnerProperties($room_id, $property_id)
    {
        $room = PropertyRoom::find($room_id);
        $property = Property::find($property_id);
        $room_photos = PropertyRoomPhoto::where('room_id', $room_id)->get();
        $room_name = $room->room_name ? ucwords(strtolower($room->room_name)) : '';
        $room_type = $room->room_type ? ucwords(strtolower($room->room_type)) : '';
        $title = 'Kamar ' . $room_name . ' Tipe ' . $room_type;

        return view('properties.showRoomOwnerProperties', compact(
            'title',
            'property',
            'room',
            'room_photos',
        ));
    }

    public function createRoomOwnerProperties($room_id, $property_id)
    {
        $room = PropertyRoom::find($room_id);
        $property = Property::find($property_id);
        $room_photos = PropertyRoomPhoto::where('room_id', $room_id)->get();
        $room_name = $room->room_name ? ucwords(strtolower($room->room_name)) : '';
        $room_type = $room->room_type ? ucwords(strtolower($room->room_type)) : '';
        $title = 'Kamar ' . $room_name . ' Tipe ' . $room_type;

        return view('properties.createRoomOwnerProperties', compact(
            'title',
            'property',
            'room',
            'room_photos',
        ));
    }

    public function storeRoomOwnerProperties(Request $request, $room_id, $property_id)
    {
        $room = PropertyRoom::find($room_id);
        $property = Property::find($property_id);
        DB::transaction(function ()  use ($request, $room, $property) {
            $request->validate([
                'property_id' => 'required',
                'room_id' => 'required',
            ]);

            $old_room_photo_file_path = $request->input('old_room_photo_file_path', []);
            $old_room_photo_file_name = $request->input('old_room_photo_file_name', []);
            $room_photo_file_path = $request->file('room_photo_file_path', []);

            PropertyRoomPhoto::where('room_id', $room->id)->delete();

            $all_photos = array_unique(array_merge(
                array_keys($old_room_photo_file_path),
                array_keys($room_photo_file_path)
            ));

            foreach ($all_photos as $ap) {
                if (isset($room_photo_file_path[$ap]) && $room_photo_file_path[$ap] && $room_photo_file_path[$ap]->isValid()) {
                    $rpfp = $room_photo_file_path[$ap]->store('room_photo_file_path');
                    $rpfn = $room_photo_file_path[$ap]->getClientOriginalName();
                } elseif (!empty($old_room_photo_file_path[$ap]) && !empty($old_room_photo_file_name[$ap])) {
                    $rpfp = $old_room_photo_file_path[$ap];
                    $rpfn = $old_room_photo_file_name[$ap];
                } else {
                    continue;
                }

                PropertyRoomPhoto::create([
                    'property_id' => $property->id,
                    'room_id' => $room->id,
                    'room_photo_file_path' => $rpfp,
                    'room_photo_file_name' => $rpfn,
                ]);
            }

        });

        return redirect('/properties/owner/room/show/'.$room->id.'/'.$property->id)->with('success', 'Data Berhasil Disimpan');
    }

    public function userProperties()
    {
        $title = 'Cari Kos / Kontrakan';
        $search = request()->input('search');

        $properties = Property::where('status', 'Disetujui')
        ->when($search, function ($query) use ($search) {
            $query->where('name', 'LIKE', '%' . $search . '%')
            ->orWhere('category', 'LIKE', '%' . $search . '%')
            ->orWhere('address', 'LIKE', '%' . $search . '%');
        })
        ->orderBy('count_click', 'DESC')
        ->paginate(20)
        ->withQueryString();

        return view('properties.userProperties', compact(
            'title',
            'properties',
        ));
    }

    public function showUserProperties($id)
    {
        $title = 'Cari Kos / Kontrakan';
        $property = Property::find($id);

        $property->update([
            'count_click' => $property->count_click + 1
        ]);

        return view('properties.showUserProperties', compact(
            'title',
            'property',
        ));
    }

    public function rentUserProperties($id)
    {
        $title = 'Pengajuan Sewa';
        $property = Property::find($id);
        if (old('room_id')) {
            $room = PropertyRoom::find(old('room_id'));
            $one_month_price = $room->one_month_price;
            $three_month_price = $room->three_month_price;
            $six_month_price = $room->six_month_price;
            $twelve_month_price = $room->twelve_month_price;
            $deposit_price = $room->deposit_price;
        } else {
            $room = null;
            $one_month_price = 0;
            $three_month_price = 0;
            $six_month_price = 0;
            $twelve_month_price = 0;
            $deposit_price = 0;
        }

        return view('properties.rentUserProperties', compact(
            'title',
            'property',
            'room',
            'one_month_price',
            'three_month_price',
            'six_month_price',
            'twelve_month_price',
            'deposit_price',
        ));
    }

    public function getCity(Request $request)
    {
        $cities = City::where('province_id', $request->province_id)->orderBy('name')->get();
        return response()->json($cities);
    }

    public function getDistrict(Request $request)
    {
        $districts = District::where('city_id', $request->city_id)->orderBy('name')->get();
        return response()->json($districts);
    }

    public function getVillage(Request $request)
    {
        $villages = Village::where('district_id', $request->district_id)->orderBy('name')->get();
        return response()->json($villages);
    }
}
