<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'id',
        'name',
        'user_id',
        'number',
        'address',
        'ward_id',
        'district_id',
        'province_id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function ward() {
        return $this->belongsTo(Ward::class);
    }
    public function district() {
        return $this->belongsTo(District::class);
    }
    public function province() {
        return $this->belongsTo(Province::class);
    }
}
