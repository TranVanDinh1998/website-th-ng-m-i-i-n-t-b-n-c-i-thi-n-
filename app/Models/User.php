<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    use SoftDeletes;
    protected $fillable = [
        'name',
        'email',
        'password',
        'image',
        'shipping_address_id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // relationship
    public function orders() {
        return $this->hasMany(Order::class)->orderByDesc('created_at');
    }
    public function addresses() {
        return $this->hasMany(Address::class);
    }
    public function address() {
        return $this->belongsTo(Address::class,'shipping_address_id');
    }
    // scope
    public function scopeActive($q)
    {
        return $q->whereVerified(1);
    }
    public function scopeGuest($q)
    {
        return $q->whereGuest(1);
    }
    public function uploadImage($image, $uploadImage)
    {
        $destination_path = 'public/images/users';
        $avatar = $uploadImage->getAvatar($image, $destination_path);
        if ($uploadImage->upload($image, $destination_path, $avatar))
            return $avatar;
        else
            return null;
    }

    public function removeImage($image, $removeImage)
    {
        $destination_path = 'public/images/users';
        if ($removeImage->remove($destination_path, $image))
            return true;
        else
            return false;
    }
}
