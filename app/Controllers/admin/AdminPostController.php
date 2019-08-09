<?php


namespace App\Controllers\Admin;


use App\Models\Admin\CategoryModel;
use App\Models\Admin\PostModel;
use App\Models\Admin\UserModel;
use Delight\Auth\Auth;
use League\Plates\Engine;

class AdminPostController extends BaseController
{
    private $id_post;

    public function __construct(Engine $engine, Auth $auth, UserModel $user, PostModel $post, CategoryModel $category )
    {
        parent::__construct($engine, $auth, $user, $post, $category);

        $array_uri = explode('/', $_SERVER['REQUEST_URI']);
        $this->id_post = $array_uri[3];
    }

    public function index()
    {
        $categories = self::$post->create();
        $posts = self::$post->index();
        $author = self::$post->getAuthors();
        $status = $author->status;
        $author = $author->username;

        echo self::$templates->render('Admin/Post/index', compact('posts', 'categories', 'author', 'status'));
    }

    public function create()
    {
        $categories = self::$post->create();
        echo self::$templates->render('Admin/Post/create', compact('categories'));
    }

    public function store()
    {
        self::$post->store();
        header("Location: /admin");
    }

    public function edit()
    {
        $categories = self::$post->create();
        $article = self::$post->edit($this->id_post);
        $userRole = self::$user->checkRole(self::$user->getUserId());
        echo self::$templates->render('Admin/Post/edit', compact('article', 'categories', 'userRole'));

    }

    public function update()
    {
        self::$post->update($_POST['id']);
        header("Location: /admin");
    }

    public function destroy()
    {
        self::$post->destroy($this->id_post);
    }

//    public function test()
//    {
//        $test = self::$post->test();
//
//        $categories = self::$post->create();
//        $categories = $categories[$test->category_id];
//        $categories = $categories['title'];
////        d($categories);
//        echo self::$templates->render('Blog/article', compact('test', 'categories'));
//    }
}
