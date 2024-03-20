<?php

namespace App\Http\Traits;

use Illuminate\Support\Facades\Storage;

trait FileUploadTrait
{
        /**
     * Uploads an image.
     *
     * @param mixed $request The request object
     * @param mixed $model_data The model data object
     * @param String $file_name The name of the file
     * @return bool
     */
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

    /**
     * Delete the old file if it exists.
     *
     * @param String $file The file to be deleted
     * @return bool
     */
    public function deleteOldFile(String $file) : bool {
        $status = false;
        if(file_exists(public_path().'/'. $file)){
            unlink(public_path().'/'. $file);
            $status = true;
        }
        return $status;
    }
}
