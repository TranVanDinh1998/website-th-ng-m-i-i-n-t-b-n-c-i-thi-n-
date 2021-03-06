<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TagProduct extends Model
{
    use HasFactory;
    use SoftDeletes;
    public $timestamps = false;

    protected $fillable = [
        'id',
        'tag_id',
        'product_id',
        'verified',
        'deleted_at',
    ];
    //relationship
    public function Tag() {
        return $this->belongsTo(Tag::class);
    }
    public function product() {
        return $this->belongsTo(Product::class);
    }
    // scope
}
