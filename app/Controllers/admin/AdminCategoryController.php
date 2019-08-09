<?php


namespace App\Controllers\admin;


use App\Models\Admin\CategoryModel;
use App\Models\Admin\PostModel;
use App\Models\Admin\UserModel;
use Delight\Auth\Auth;
use League\Plates\Engine;

class AdminCategoryController extends BaseController
{
    protected $id_category;
    public function __construct(Engine $engine, Auth $auth, UserModel $user, PostModel $post, CategoryModel $category )
    {
        parent::__construct($engine, $auth, $user, $post, $category);

        $array_uri = explode('/', $_SERVER['REQUEST_URI']);
        $this->id_category = $array_uri[4];
    }

    public function index()
    {
        $categories = self::$category->index();
        $status = self::$user->getStatus(self::$user->getUserId());
        $role = self::$user->checkRole(self::$user->getUserId());
        if ($role == 2) {
            echo self::$templates->render('Admin/Category/index3', compact('categories', 'status'));
        } else {
            echo self::$templates->render('Admin/Category/index', compact('categories', 'status'));
        }

    }
    public function create()
    {
        echo self::$templates->render('Admin/Category/create');
    }

    public function store()
    {
        self::$category->store();
        header("Location: /admin/category/all");
    }

    public function edit()
    {
        $category = self::$category->edit($this->id_category);
        $title = $category->title;
        $id_category = $this->id_category;
        echo self::$templates->render('Admin/Category/edit', compact('title', 'id_category'));
    }

    public function update()
    {
        self::$category->update($_POST['id']);
        header("Location: /admin/category/all");
    }

    public function delete()
    {
        self::$category->delete($this->id_category);
        header("Location: /admin/category/all");
    }


}
