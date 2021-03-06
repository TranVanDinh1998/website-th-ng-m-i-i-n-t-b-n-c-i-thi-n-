<?php

namespace App\Http\Helpers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class RemoveImage
{
    public function remove($path,$avatar)
    {
        return Storage::delete($path.'/'.$avatar) ? true : false;
    }
}
