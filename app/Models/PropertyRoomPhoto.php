<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PropertyRoomPhoto extends Model
{
    use HasFactory;
    protected $guarded = ["id"];

    public function property()
    {
        return $this->belongsTo(Property::class, 'property_id');
    }

    public function room()
    {
        return $this->belongsTo(PropertyRoom::class, 'room_id');
    }
}
