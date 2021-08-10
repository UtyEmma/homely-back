<?php

namespace App\Http\Libraries\Files;

use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Exception;
use Illuminate\Support\Facades\Storage;

trait FileHandler{

    public function handleFiles($file){
        !is_array($file) ? $newFile = [$file] : $newFile = $file;
        $files = $this->upload($newFile);
        !is_array($files) ? $files = json_encode([$file]) : $files = json_encode($files);
        return $files;
    }

    public function upload($files){
        if(!is_array($files)){
            throw new Exception("No files selected");
        }


        for($i=0; $i < count($files); $i++) {
            $file = $files[$i];
            if(!file_exists($file)){
                throw new Exception("No files Selected");
            }
            $url = Cloudinary::uploadFile($file->getRealPath())->getSecurePath();
            if(!$url){
                throw new Exception("File Could Not Be Saved");
            }

            $file_array[$i]['url'] = $url;
        }

        return $file_array;
    }

    public function replace($files, $type, $oldFiles, $hasFile){
        if ($oldFiles) {
            foreach ($oldFiles as $value) {
                Storage::delete($value->path);
            }
        }

        if ($hasFile) {
            $uploaded_files = $this->upload($files, $type);
            return $uploaded_files;
        }

        return null;
    }

    public function delete($files){
        if ($files) {
            foreach ($files as $value) {
                Storage::delete($value->path);
            }
        }
    }
}
