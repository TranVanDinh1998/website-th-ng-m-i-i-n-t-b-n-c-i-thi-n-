<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Product extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        'id',
        'name',
        'description',
        'image',
        'price',
        'quantity',
        'remaining',
        'rating',
        'view',
        'category_id',
        'producer_id',
        'discount',
        'verified',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    // relationship
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function producer()
    {
        return $this->belongsTo(Producer::class);
    }
    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }
    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class);
    }
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
    public function collectionProducts()
    {
        return $this->hasMany(CollectionProduct::class);
    }
    public function tagProducts()
    {
        return $this->hasMany(TagProduct::class);
    }

    // scope
    public function scopeActive($q)
    {
        return $q->whereVerified(1);
    }
    public function scopeLastest($q)
    {
        return $q->orderByDesc('created_at');
    }
    // filter
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
                case 2:
                    $query->orderBy('price', 'asc');
                    break;
                case 3:
                    $query->orderBy('rating', 'desc');
                    break;
                case 4:
                    $query->select('id', 'name', 'price', 'description', 'image', DB::raw('quantity-remaining as leftover'))->orderByDesc('leftover');
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

    public function scopeDate($query, $request)
    {
        if ($request->has('date_from') && !$request->has('date_to')) {
            $query->whereDate('created_at', '>', $request->date_from);
        } elseif ($request->has('date_to') && !$request->has('date_from')) {
            $query->whereDate('created_at', '<', $request->date_to);
        } elseif ($request->has('date_from') && ($request->has('date_to'))) {
            $query->whereBetween('created_at', [$request->date_from, $request->date_to]);
        }
        return $query;
    }

    public function scopePrice($query, $request)
    {
        $price_from = $request->price_from;
        $price_to = $request->price_to;
        if ($price_from != null && $price_to == null) {
            $query->where('price', '>', $price_from);
        }
        if ($price_from == null && $price_to != null) {
            $query->where('price', '<', $price_to);
        }
        if ($price_from != null && $price_to != null) {
            $query->whereBetween('price', [$price_from, $price_to]);
        }
        return $query;
    }

    public function scopeRemaining($query, $request)
    {
        if ($request->has('remaining') && $request->remaining != null) {
            $query->where('remaining', $request->remaining);
        }
        return $query;
    }

    public function scopeCategory($query, $request)
    {
        if ($request->has('category_id') && $request->category_id != null) {
            $query->where('category_id', $request->category_id);
        }
        return $query;
    }

    public function scopeMassCategory($query, $request)
    {
        if ($request->has('category_id_list') && $request->category_id_list != null) {
            $query->whereIn('category_id', $request->category_id_list);
        }
        return $query;
    }

    public function scopeProducer($query, $request)
    {
        if ($request->has('producer_id') && $request->producer_id != null) {
            $query->where('producer_id', $request->producer_id);
        }
        return $query;
    }

    public function scopeMassProducer($query, $request)
    {
        if ($request->has('producer_id_list') && $request->producer_id_list != null) {
            $query->whereIn('producer_id', $request->producer_id_list);
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


    //helper
    public function uploadImage($image, $uploadImage)
    {
        $destination_path = 'public/images/products';
        $avatar = $uploadImage->getAvatar($image, $destination_path);
        if ($uploadImage->upload($image, $destination_path, $avatar))
            return $avatar;
        else
            return null;
    }

    public function removeImage($image, $removeImage)
    {
        $destination_path = 'public/images/products';
        if ($removeImage->remove($destination_path, $image))
            return true;
        else
            return false;
    }

    protected static function boot()
    {
        parent::boot();
        self::deleting(function ($product) {
            $product->images()->delete();
            $product->orderDetails()->delete();
            $product->reviews()->delete();
            $product->collectionProducts()->delete();
            $product->tagProducts()->delete();
            if ($product->forceDeleting) {
                $product->images()->forceDelete();
                $product->orderDetails()->forceDelete();
                $product->reviews()->forceDelete();
                $product->collectionProducts()->forceDelete();
                $product->tagProducts()->forceDelete();
            }
        });
        self::restoring(function ($product) {
            $product->images()->onlyTrashed()->restore();
            $product->orderDetails()->onlyTrashed()->restore();
            $product->reviews()->onlyTrashed()->restore();
            $product->collectionProducts()->onlyTrashed()->restore();
            $product->tagProducts()->onlyTrashed()->restore();
        });
    }
}
