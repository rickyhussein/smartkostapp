<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserProperty extends Model
{
    use HasFactory;

    protected $guarded = ["id"];

    public function room()
    {
        return $this->belongsTo(PropertyRoom::class, 'room_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function property()
    {
        return $this->belongsTo(Property::class, 'property_id');
    }
    
    public function rent()
    {
        return $this->belongsTo(Rent::class, 'rent_id');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'rent_id');
    }

    public function transaction($id)
    {
        return Transaction::where('rent_id', $id)->where('active', 1)->first();
    }
}
