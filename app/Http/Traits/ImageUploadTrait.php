<?php

namespace App\Http\Traits;

use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;

trait ImageUploadTrait
{
    public function uploadImage($file, $folder_name)
    {
        try {
            $file_name =  time() . '_'. $file->getClientOriginalName();
            $path = "images/" . $folder_name;
            $file_full_name = $path . $file_name;
            $file->move($path, $file_name);

            return $file_full_name;

        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    public function deleteImage($file_name)
    {
        if (File::exists($file_name)) {
            File::delete($file_name);
            return true;
        }

        return false;
    }
}
