<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CollectionProduct extends Model
{
    use HasFactory;
    use SoftDeletes;
    public $timestamps = false;

    protected $fillable = [
        'id',
        'collection_id',
        'product_id',
        'verified',
        'deleted_at',
    ];
    //relationship
    public function collection() {
        return $this->belongsTo(Collection::class);
    }
    public function product() {
        return $this->belongsTo(Product::class);
    }
    // scope
}
