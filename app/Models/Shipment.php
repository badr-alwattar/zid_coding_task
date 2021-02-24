<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shipment extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function documents() {
        return $this->hasMany(Document::class);
    }

    public function statuses() {
        return $this->belongsToMany(Status::class)->using(ShipmentStatus::class)->withTimeStamps();
    }
}
