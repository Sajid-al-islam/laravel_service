<?php

namespace App\Http\Traits;

use Illuminate\Support\Facades\Storage;

trait FileUploadTrait
{
    public function uploadImage(mixed $request, mixed $model_data, String $file_name)
    {
        $status = false;
        if ($request->hasFile($file_name)) {
            $model_data->$file_name = $request->file($file_name)->store('public/uploads/user', 'local');
            $model_data->save();
            $status = true;
        }
        return $status;
    }

    public function deleteOldFile(String $file) : bool {
        $status = false;
        if(file_exists(public_path().'/'. $file)){
            unlink(public_path().'/'. $file);
            $status = true;
        }
        return $status;
    }
}
