<?php

namespace App\Models;

use App\Http\Helpers\UploadImage;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tag extends Model
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
    public function tagProducts() {
        return $this->hasMany(tagProduct::class);
    }
    // scope

    protected static function boot() {
        parent::boot();
        self::deleting(function($tag) {
            $tag->tagProducts()->delete();
            if ($tag->forceDeleting) {
                $tag->tagProducts()->forceDelete();
            }
        });
        self::restoring(function($tag) {
            $tag->tagProducts()->onlyTrashed()->restore();
        });
    }

}
