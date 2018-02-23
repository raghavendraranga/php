<?php

namespace App\Lib\Helpers\Images;

use App\Lib\Helpers\Images\Image;

class Resize
{

    //image resize fucntion comes here..
    public function resize($filename, $width, $height,$file_path)
    {
        //exit($filename);
        //echo DIR_IMAGE . $filename;
        //dd();
        if (!file_exists($file_path . $filename) || !is_file($file_path . $filename)) {
            
            return;
        }
        $info = pathinfo($filename);

        $extension = $info['extension'];

        $old_image = $filename;
        //$new_image = config('backend.images.resized_folder') . substr($filename, 0, strrpos($filename, '.')) . '-' . $width . 'x' . $height . '.' . $extension;
        $new_image =  substr($filename, 0, strrpos($filename, '.')) . '-' . $width . 'x' . $height . '.' . $extension;
        if (!file_exists($file_path . $new_image) || (filemtime($file_path . $old_image) > filemtime($file_path . $new_image))) {
            $path = '';

            $directories = explode('/', dirname(str_replace('../', '', $new_image)));

            foreach ($directories as $directory) {
                $path = $path . '/' . $directory;

                if (!file_exists($file_path . $path)) {
                    @mkdir($file_path . $path, 0777);
                }
            }

            $image = new Image($file_path . $old_image);
            $image->resize($width, $height);
            $saveimage = $image->save($file_path . $new_image);
            return  $new_image;
        } else {
            return  $new_image;
        }
    }

}
