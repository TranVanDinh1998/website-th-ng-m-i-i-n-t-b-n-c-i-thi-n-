<?php

namespace App\Models;

use App\Http\Helpers\UploadImage;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Collection extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        'id',
        'name',
        'description',
        'image',
        'category_id',
        'priority',
        'verified',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    // relationship
    public function category() {
        return $this->belongsTo(Category::class);
    }
    public function collectionProducts() {
        return $this->hasMany(CollectionProduct::class);
    }
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
    public function scopeSearch($query, $request)
    {
        if ($request->has('search') && $request->search != null) {
            $query->where('name', 'LIKE', '%' . $request->search . '%')
                ->orWhere('name', 'LIKE', $request->search . '%')
                ->orWhere('name', 'LIKE', '%' . $request->search);
        }
        return $query;
    }
    // get 
    public function uploadImage($image, $uploadImage)
    {
        $destination_path = 'public/images/collections';
        $avatar = $uploadImage->getAvatar($image, $destination_path);
        if ($uploadImage->upload($image, $destination_path, $avatar))
            return $avatar;
        else
            return null;
    }

    public function removeImage($image, $removeImage)
    {
        $destination_path = 'public/images/collections';
        return $removeImage->remove($destination_path, $image);
    }

    protected static function boot() {
        parent::boot();
        self::deleting(function($collection) {
            $collection->collectionProducts()->delete();
            if ($collection->forceDeleting) {
                $collection->collectionProducts()->forceDelete();
            }
        });
        self::restoring(function($collection) {
            $collection->collectionProducts()->onlyTrashed()->restore();
        });
    }

}
