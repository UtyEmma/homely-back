<?php

namespace App\Http\Libraries\Files;

use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Exception;

trait FileHandler{

    public function handleFiles($file, $update = false, $old_files = []){
        !is_array($file) ? $newFile = [$file] : $newFile = $file;
        $files = $update ? $this->update($file, $old_files) : $this->upload($newFile);
        !is_array($files) ? $files = json_encode([$file]) : $files = json_encode($files);
        return $files;
    }

    private function upload($files){
        is_array($files) ?: throw new Exception("No files selected");

        for($i=0; $i < count($files); $i++) {
            $file = $files[$i];
            file_exists($file) ?: throw new Exception("No files Selected");
            $url = Cloudinary::uploadFile($file->getRealPath())->getSecurePath() ?: throw new Exception("File Could Not Be Saved");
            // $url ?: throw new Exception("File Could Not Be Saved");
            $file_array[$i] = $url;
        }
        return $file_array;
    }
    
    public function replace($files, $old_files){   
        if($old_files){
            foreach (json_decode($old_files) as $key => $file) {
                $this->deleteFile($file);
            }
        }
        return $this->upload($files);
    }

    private function deleteFile($file){
        $cloudinary_id = $this->extractFileId($file);
        Cloudinary::destroy($cloudinary_id);
    }

    private function extractFileId($file){
        $ext = pathinfo($file, PATHINFO_EXTENSION);
        return basename($file, $ext);
    }
}
