<?php

namespace App\Models;

use App\Http\Helpers\UploadImage;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contact extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        'id',
        'name',
        'email',
        'number',
        'comment',
        'verified',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    // scope
    public function scopeActive($q) {
        return $q->whereVerified(1);
    }
    public function scopeLastest($q) {
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

    public function scopeRead($query)
    {
        $query->where('verified', 1);
        return $query;
    }
    public function scopeUnread($query)
    {
        $query->where('verified', 0);
        return $query;
    }

}
