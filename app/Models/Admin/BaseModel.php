<?php


namespace App\Models\Admin;


use App\Models\Model;
use Delight\Auth\Auth;
use \RedBeanPHP\R as R;

class BaseModel extends Model
{
    protected static $auth;

    public function __construct( Auth $auth )
    {
        self::$auth = $auth;
    }

    public function slug()
    {
        if ( empty($_POST['slug']) ) {
            $slug = strtolower($_POST['title']);
        } else {
            $slug = strtolower($_POST['slug']);
        }
            $slug = str_replace("-", '_',
                    str_replace("'", '',
                    str_replace(' ', '_',
                    $slug)));
            $bean = R::findOne('articles', 'slug = ?', array($slug));
            if ( $bean != null ) {
                echo "This is a duplicate, change your Slug";die;
            } else {
                return $slug;
            }
    }

    public function loadImg($titleController, $titleCategory = '', $titleFile)
    {
        $path = 'images/' . $titleController . '/';
        if ($titleCategory != '') $path .= str_replace( ' ', '_', strtolower($titleCategory)) . '/';
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


