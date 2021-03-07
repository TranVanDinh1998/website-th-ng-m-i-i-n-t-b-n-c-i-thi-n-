<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        'id',
        'user_id',
        'discount',
        'sub_total',
        'total',
        'status',
        'paid',
        'done',
        'verified',
        'delivered_at',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function orderDetails() {
        return $this->hasMany(OrderDetail::class);
    }
    public function shippingAddress() {
        return $this->hasOne(ShippingAddress::class);
    }
    public function user() {
        return $this->hasOne(User::class);
    }

    protected static function boot()
    {
        parent::boot();
        self::deleting(function ($order) {
            $order->orderDetails()->delete();
            if ($order->forceDeleting) {
                $order->orderDetails()->forceDelete();
            }
        });
        self::restoring(function ($order) {
            $order->orderDetails()->onlyTrashed()->restore();
        });
    }
    
    // filter
    public function scopeLatest($q)
    {
        return $q->orderByDesc('created_at');
    }
    public function scopeSortId($query, $request)
    {
        if ($request->has('sort_id') && $request->sort_id != null) {
            switch ($request->sort_id) {
                case 0:
                    $query->orderBy('id', 'asc');
                    break;
                case 1:
                    $query->orderBy('id', 'desc');
                    break;
            }
        }
        else {
            $query->orderBy('id', 'desc');
        }
        return $query;
    }
    
    public function scopeSortTotal($query, $request)
    {
        if ($request->has('sort_total') && $request->sort_id != null) {
            switch ($request->sort_id) {
                case 0:
                    $query->orderBy('total', 'asc');
                    break;
                case 1:
                    $query->orderBy('total', 'desc');
                    break;
            }
        }
        return $query;
    }

    public function scopeSortDate($query, $request)
    {
        if ($request->has('sort_date') && $request->sort_id != null) {
            switch ($request->sort_id) {
                case 0:
                    $query->orderBy('created_at', 'asc');
                    break;
                case 1:
                    $query->orderBy('created_at', 'desc');
                    break;
            }
        }
        else {
            $query->orderBy('created_at', 'desc');
        }
        return $query;
    }

    public function scopeSortPaid($query, $request)
    {
        if ($request->has('sort_paid') && $request->sort_id != null) {
            switch ($request->sort_id) {
                case 0:
                    $query->where('paid',0);
                    break;
                case 1:
                    $query->where('paid', 1);
                    break;
            }
        }
        return $query;
    }
    public function scopeStatus($query, $request)
    {
        if ($request->has('status') && $request->status != null) {
            switch ($request->status) {
                case 0:
                    $query->where('status', 0);
                    break;
                case 1:
                    $query->where('status', 1);
                    break;
                case 2:
                    $query->where('status', 2);
                    break;
                case 3:
                    $query->where('status', 3);
                    break;
            }
        }
        return $query;
    }

    public function scopeActive($query)
    {
        $query->where('verified', 1);
        return $query;
    }

    public function scopeInactive($query)
    {
        $query->where('verified', 0);
        return $query;
    }

    public function scopePay($query)
    {
        $query->where('paid', 1);
        return $query;
    }

    public function scopeNotPay($query)
    {
        $query->where('paid', 0);
        return $query;
    }

    public function scopeDone($query)
    {
        $query->where('done', 1);
        return $query;
    }

    public function scopeNotDone($query)
    {
        $query->where('done', 0);
        return $query;
    }
}
