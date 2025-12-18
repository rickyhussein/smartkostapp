<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    use HasFactory;
    protected $guarded = ["id"];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function photos()
    {
        return $this->hasMany(PropertyPhoto::class, 'property_id');
    }

    public function rooms()
    {
        return $this->hasMany(PropertyRoom::class, 'property_id');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function province()
    {
        return $this->belongsTo(Province::class, 'province_id');
    }

    public function city()
    {
        return $this->belongsTo(City::class, 'city_id');
    }

    public function district()
    {
        return $this->belongsTo(District::class, 'district_id');
    }

    public function village()
    {
        return $this->belongsTo(Village::class, 'village_id');
    }

    public function facilities()
    {
        return $this->hasMany(PropertyFacility::class, 'property_id');
    }

    public function regulations()
    {
        return $this->hasMany(PropertyRegulation::class, 'property_id');
    }

    public function countAvailable($id)
    {
        $count = PropertyRoom::where('property_id', $id)->whereNull('is_available')->count();
        return $count;
    }

    public function roomAvailable($id)
    {
        $room = PropertyRoom::where('property_id', $id)->whereNull('is_available')->get();
        return $room;
    }

    public function countUnavailable($id)
    {
        $count = PropertyRoom::where('property_id', $id)->whereNotNull('is_available')->count();
        return $count;
    }

    public function roomUnavailable($id)
    {
        $room = PropertyRoom::where('property_id', $id)->whereNotNull('is_available')->get();
        return $room;
    }

    public function whatsapp($phoneNumber)
    {
        if (substr($phoneNumber, 0, 1) == '0') {
            return '62' . substr($phoneNumber, 1);
        }
        return $phoneNumber;
    }


}
