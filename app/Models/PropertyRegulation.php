<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PropertyRegulation extends Model
{
    use HasFactory;
    protected $guarded = ["id"];

    public function property()
    {
        return $this->belongsTo(Property::class, 'property_id');
    }

    public function regulation()
    {
        return $this->belongsTo(Regulation::class, 'regulation_id');
    }
}
