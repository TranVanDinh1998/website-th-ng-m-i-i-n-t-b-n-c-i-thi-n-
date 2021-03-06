<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductImage extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        'id',
        'image',
        'product_id',
        'verified',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    // scope


    // get 
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
}
