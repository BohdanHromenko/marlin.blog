<?php


namespace App\Controllers\Admin;


use App\Controllers\Controller;
use App\Models\Admin\CategoryModel;
use App\Models\Admin\PostModel;
use App\Models\Admin\UserModel;
use Delight\Auth\Auth;
use League\Plates\Engine;

abstract class BaseController extends Controller
{
    protected static $auth;
    protected static $user;
    protected static $post;
    protected static $category;

    public function __construct(Engine $engine, Auth $auth, UserModel $user, PostModel $post, CategoryModel $category )
    {
        parent::__construct($engine);
        self::$auth = $auth;
        self::$user = $user;
        self::$post = $post;
        self::$category = $category;

        $uri = $_SERVER['REQUEST_URI'];
        if (!self::$auth->isLoggedIn()) {
            if ( $uri != "/admin/login" && $uri != "/admin/sign-up" ) {
                header("Location: /admin/login");
            }
        }
    }
}
