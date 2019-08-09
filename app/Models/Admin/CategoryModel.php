<?php


namespace App\Models\Admin;

use Delight\Auth\Auth;
use \RedBeanPHP\R as R;

class CategoryModel extends BaseModel
{
    private $user;

    public function __construct(Auth $auth, UserModel $user)
    {
        parent::__construct($auth);
        self::bean();
        $this->user = $user;
    }

    public function index()
    {
        return $this->getAll('categories');
    }

    public function store()
    {
        $category = R::dispense('categories');
        $category->title = $_POST['title'];
        return R::store($category);
    }

    public function edit($id)
    {
        return R::load('categories', $id);
    }

    public function update($id)
    {
        $category = $this->edit($id);
        $category->title = $_POST['title'];
        R::store($category);
    }

    public function delete($id)
    {
        $category = R::load('categories', $id);
        R::trash( $category );
    }


}
