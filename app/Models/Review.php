<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Review extends Model
{
    use HasFactory;
    use SoftDeletes;

    public function user() {
        return $this->belongsTo(User::class);
    }
    public function product() {
        return $this->belongsTo(Product::class);
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
        return $query;
    }

    public function scopeSort($query, $request)
    {
        if ($request->has('sort')) {
            switch ($request->sort) {
                case 0:
                    $query->orderBy('id', 'asc');
                    break;
                case 1:
                    $query->orderBy('name', 'asc');
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
                    $query->where('verified', 0);
                    break;
                case 1:
                    $query->where('verified', 1);
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
}
