<?php

namespace App\Http\Helpers;

use Illuminate\Support\Str;

class UploadImage
{
    public function massUpload($files, $path) {
        foreach ($files as $file) {
            $avatar = null;
            $avatar = $this->getAvatar($file,$path);
            $upload = $this->upload($file,$path,$avatar);
            if (!$upload)
                return false;
        }
        return true;
    }
    public function upload($file, $path,$avatar)
    {
        return $file->storeAs($path, $avatar) ? true : false;
    }

    public function checkIfExists($file, $path)
    {
        return (file_exists($path . '/' . $file->getClientOriginalName())) ? true : false;
    }

    public function getAvatar($file, $path)
    {
        $avatar = $file->getClientOriginalName();
        while ($this->checkIfExists($file, $path)) {
            $avatar = Str::random(4) . '_' . $avatar;
        }
        return $avatar;
    }
}
