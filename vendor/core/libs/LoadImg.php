<?php


namespace vendor\core\libs;

class LoadImg
{
    public static function load($titleController, $titleCategory = '', $titleFile)
    {
        $path = 'images/' . $titleController . '/';
        if ($titleCategory != '') $path .= strtolower($titleCategory) . '/';
        if ( $_FILES ) $extension = '.';
        $extension .= strtolower(substr(strrchr($_FILES['file']['name'], '.'), 1));

        if ( empty($titleFile) ) {
            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $charactersLength = strlen($characters);
            $filename = '';
            for ($i = 0; $i < 20; $i++) {
                $filename .= $characters[rand(0, $charactersLength - 1)];
            }
        } else {
            $filename = strtolower($titleFile);
        }
        $filename = str_replace("'", '', $filename);
        $filename = str_replace(' ', '-', $filename);
        $filename = $filename . $extension;
        if ( !file_exists($path) ) {
            mkdir($path, 0777, true);
        }
        $target = $path . $filename;
        if (!file_exists($target) && $filename) {
            if (!empty($_FILES)) {
                move_uploaded_file($_FILES['file']['tmp_name'], $target);
            }
            return $target;
        }else{
            return false;
        }
    }


}
