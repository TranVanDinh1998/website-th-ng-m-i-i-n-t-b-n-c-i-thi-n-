<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderDetail extends Model
{
    use HasFactory;
    use SoftDeletes;
    public $timestamps = false;
    protected $fillable = [
        'id',
        'order_id',
        'product_id',
        'product_discount',
        'price',
        'quantity',
        'deleted_at',
    ];

    public function product() {
        return $this->belongsTo(Product::class);
    }


}
