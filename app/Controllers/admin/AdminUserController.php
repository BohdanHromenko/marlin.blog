<?php

namespace App\Controllers\Admin;

use App\Models\Admin\UserModel;
use App\Models\Admin\CategoryModel;
use App\Models\Admin\PostModel;
use Delight\Auth\Auth;
use League\Plates\Engine;

class AdminUserController extends BaseController
{
    private $userRole;
    private $array_uri;

    public function __construct(Engine $engine, Auth $auth, UserModel $user, PostModel $post, CategoryModel $category )
    {
        parent::__construct($engine, $auth, $user, $post, $category);

        $this->array_uri = explode('/', $_SERVER['REQUEST_URI']);

        if ($auth->isLoggedIn()) {
            $this->userRole = self::$user->checkRole(self::$user->getUserId());
        }
    }

    public function index()
    {
//        $langTitle = self::$user->getLanguageTitle();
//        $langDesc = self::$user->getLanguageDescription();
        $userRole = $this->userRole;
        $users = self::$user->index(self::$user->checkRole(self::$user->getUserId()), self::$user->getUserId());
        $titleStatus = self::$user->getActualStatus();
        $titleRole = self::$user->getTitleRole();
        echo self::$templates->render('Admin/Auth/index', compact('users', 'titleRole', 'titleStatus', 'userRole', 'langDesc', 'langTitle'));
    }

    public function loginForm()
    {
        echo self::$templates->render('Admin/Auth/login');
    }

    public function login()
    {
        self::$user->login();
    }

    public function signUpForm()
    {
        echo self::$templates->render('Admin/Auth/signUp');
    }

    public function signUp()
    {
        self::$user->signUp();
    }

    public function logout()
    {
        self::$user->logout();
        header("Location: /admin");
    }

    public function verification()
    {
        self::$user->verification();
    }

    public function edit()
    {
        $id = (int)$this->array_uri[4];
        $id_logined = self::$user->getUserId();
        $userRole = $this->userRole;

        $allowed_id = self::$user->index($userRole, $id);
        foreach ($allowed_id as $item) {
            if ($id == $item['id']) {

                $actualStatus = self::$user->getActualStatus();
                $titleRole = self::$user->getTitleRole();

                $user = self::$user->edit($id);

                $role = $user->roles_mask;
                $email = $user->email;
                $username = $user->username;
                $status = $user->status;
                $verified = $user->verified;
                $avatar = $user->avatar;

                echo self::$templates->render('Admin/Auth/edit', compact('email', 'username', 'status', 'verified',
                    'avatar', 'id_logined', 'id', 'userRole', 'actualStatus', 'titleRole', 'role'));
            }
        }




    }
    public function update()
    {
        self::$user->update();
    }
    public function delete()
    {
        self::$user->destroy($this->array_uri[4]);
    }


}
