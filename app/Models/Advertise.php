<?php

namespace App\Models;

use App\Http\Helpers\UploadImage;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Advertise extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        'id',
        'name',
        'summary',
        'description',
        'image',
        'product_id',
        'verified',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    // relationship
    public function product() {
        return $this->belongsTo(Product::class);
    }
    // scope
    public function scopeActive($q) {
        return $q->whereVerified(1);
    }
    public function scopeLatest($q) {
        return $q->orderByDesc('created_at');
    }
    // get 
    public function uploadImage($image, $uploadImage)
    {
        $destination_path = 'public/images/advertises';
        $avatar = $uploadImage->getAvatar($image, $destination_path);
        if ($uploadImage->upload($image, $destination_path, $avatar))
            return $avatar;
        else
            return null;
    }

    public function removeImage($image, $removeImage)
    {
        $destination_path = 'public/images/advertises';
        return $removeImage->remove($destination_path, $image);
    }

}
