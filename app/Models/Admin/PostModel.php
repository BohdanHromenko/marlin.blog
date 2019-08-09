<?php


namespace App\Models\Admin;

use \RedBeanPHP\R as R;
use Delight\Auth\Auth;
use Tamtamchik\SimpleFlash\Flash;
use Faker;


class PostModel extends BaseModel
{
    private $flash;
    public $loadImg;
    protected $user;

    public function __construct(Auth $auth, Flash $flash, UserModel $user)
    {
        parent::__construct( $auth );
        $this->flash = $flash;
        $this->user = $user;
    }

    public function index()
    {
        $id = self::$auth->getUserId();
        $role = $this->user->checkRole($id);
        if ( $role == 1 || $role == 1024 ) {
            return R::findAll("articles", " ORDER BY date DESC");
        } else {
            return R::getAll("SELECT * FROM articles WHERE author=:author", [':author' => $this->user->getUserId()]);
        }
    }
    public function getOnePost()
    {

    }

    public function getAuthors()
    {
        return R::load('users', $this->user->getUserId());
    }

    public function create()
    {
        return $this->getAll('categories');
    }

    public function store()
    {
        // $faker = Faker\Factory::create();


        // for ($i = 0; $i < 50; $i++) {
        //     $fake = R::dispense('articles');
        //     $fake->title = $faker->name;
        //     $fake->title_pl = $faker->name;
        //     $fake->title_ru = $faker->name;
        //     $fake->title_de = $faker->name;
        //     $fake->slug = $faker->slug;
        //     $fake->status = 1;
        //     $fake->all_desc = $faker->realText(rand(500,1000));
        //     $fake->all_desc_pl = $faker->realText(rand(500,1000));
        //     $fake->all_desc_ru = $faker->realText(rand(500,1000));
        //     $fake->all_desc_de = $faker->realText(rand(500,1000));
        //     $fake->category_id = rand(1,5);
        //     $fake->images = $faker->image('images\post', '900', '500', 'cats');
        //     $fake->author = rand(1,3);
        //     $fake->views = 0;
        //     R::store($fake);
        // }
        // R::store($fake);
        // header("Location: /admin");



        $author = self::$auth->getUserId();
        $title = $_POST['title'];
        $title_pl = $_POST['title_pl'];
        $title_ru = $_POST['title_ru'];
        $title_de = $_POST['title_de'];
        $slug = $this->slug();
        $description = $_POST['all_desc'];
        $description_pl = $_POST['all_desc_pl'];
        $description_ru = $_POST['all_desc_ru'];
        $description_de = $_POST['all_desc_de'];


        $views = 0;
        $file = self::loadImg('post', $_POST['category'], $_POST['title_img']);
        $id_category = R::getAll("SELECT id FROM categories WHERE title=:title", [':title' => $_POST['category']]);
        $id_category = $id_category[0]['id'];

        if ($file != false){
            $post = R::dispense('articles');

            $post->title = $title;
            $post->title_pl = $title_pl;
            $post->title_ru = $title_ru;
            $post->title_de = $title_de;
            $post->slug = $slug;
            $post->all_desc = $description;
            $post->all_desc_ru = $description_ru;
            $post->all_desc_pl = $description_pl;
            $post->all_desc_de = $description_de;
            $post->category_id = $id_category;
            $post->author = $author;
            $post->views = $views;
            $post->images = $file;
            if ( $_POST['date'] != '' ) $post->date = $_POST['date'];

            R::store($post);
        } else {
            echo "File is exist with the same name";
            exit;
        }
    }

    public function edit($id)
    {
        $role = $this->user->checkRole(self::$auth->getUserId());
            if ( $role == 2 ) {
                $bean = R::getCol("SELECT id FROM articles WHERE author=:author", [':author' => self::$auth->getUserId()]);
                    foreach ($bean as $item) {
                        if ( $id == $item ) {
                            return $this->load('articles', $id);
                        }
                    }
            } else {
                return $this->load('articles', $id);
            }
    }
// Update post
    public function update($id)
    {
        $category_id            = R::getAll("SELECT id FROM  categories WHERE title = :title",
            [':title' => $_POST['category_id']]);
        $articles               = $this->edit($id);

        $articles->title        = $_POST['title'];
        $articles->title_pl     = $_POST['title_pl'];
        $articles->title_ru     = $_POST['title_ru'];
        $articles->title_de     = $_POST['title_de'];
        $articles->slug         = $_POST['slug'];
        $articles->date         = $_POST['date'];
        $articles->all_desc     = $_POST['all_desc'];
        $articles->all_desc_pl  = $_POST['all_desc_pl'];
        $articles->all_desc_ru  = $_POST['all_desc_ru'];
        $articles->all_desc_de  = $_POST['all_desc_de'];
        $articles->category_id  = $category_id[0]['id'];
        if ( $_POST['status'] == 'Verification' ) $articles->status = 0;
        if ( $_POST['status'] == 'Active' ) $articles->status = 1;

        if ( $_FILES['file']['name'] != null ) {
            if ( file_exists($articles->images) ) {
                unlink($articles->images);
                $articles->images = self::loadImg('post', $_POST['category_id'], $_POST['title_img']);
            }
        }
        R::store($articles);
    }

// Destroy post & file of post
    public function destroy($id)
    {
        if (self::$auth->isLoggedIn()) {
            $post = $this->load('articles', $id);
            $filename = "images/" . $post->images;
            if (file_exists($filename)) {
                unlink($filename);
            } else {
                R::trash($post);
            }
            R::trash($post);
            header('Location: /admin');
        }
    }


}
