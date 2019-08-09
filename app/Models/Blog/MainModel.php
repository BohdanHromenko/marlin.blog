<?php


namespace App\Models\Blog;

use App\Models\Admin\UserModel;
use Delight\Auth\Auth;
use \RedBeanPHP\R as R;


class MainModel extends BaseModel
{
    private $category_id;
    private static $auth;
    private static $user;

    public function __construct(Auth $auth, UserModel $user)
    {
        parent::bean();
        self::$auth = $auth;
        self::$user = $user;
    }

    public function index($page)
    {
        if (empty($page)) $page = 1;
        return R::findAll('articles', 'WHERE status=1 ORDER BY id DESC LIMIT ?,? ', array((($page-1)*LIMIT),LIMIT));
    }

    public function amountPages()
    {
        return ceil(R::count('articles', 'WHERE status=1')/LIMIT);
    }

    public function categories()
    {
        return R::getAll("SELECT * FROM categories");
    }

    public function categoryOne($category_slug, $page)
    {
        $this->category_id = R::getRow("SELECT * FROM categories WHERE  slug LIKE ? LIMIT 1",
            array($category_slug));
        if (empty($page)) $page = 1;
        $category = R::findLike('articles', [
            'category_id' => $this->category_id['id'],
            'status' => 1
        ], ' ORDER BY id DESC LIMIT ?,?', array((($page-1)*LIMIT),LIMIT));
        if ( $this->category_id != null ) {
            return $category;
        } else {
            require_once "404.html";
            die;
        }
    }

    public function postsOfAuthor($author, $page)
    {
        if (empty($page)) $page = 1;
        $id = R::getAssoc("SELECT id FROM users WHERE username=:username", [':username' => $author]);
        $oneAuthor = R::findLike('articles', [
            'author' => $id,
            'status' => 1
        ], ' ORDER BY id DESC LIMIT ?,?', array((($page-1)*LIMIT),LIMIT));
        if ( $oneAuthor != null ) {
            return $oneAuthor;
        } else {
            require_once "404.html";
            die;
        }
    }

    public function amountPagesWhereCategory()
    {
        return ceil(R::count('articles', ' category_id = ? ', [$this->category_id['id']])/LIMIT);
    }

    public function amountPagesWhereAuthor($author)
    {
        $id = R::getRow("SELECT id FROM users WHERE username=:username", [':username' => $author]);
        return ceil(R::count('articles', ' author = ? ', [$id['id']])/LIMIT);
    }

    public function article($slug)
    {
        if ( self::$auth->isLoggedIn() == true ) {
            $article = R::findOne('articles', ' slug = ? ', [$slug]);
        } else {
            $article = R::findOne('articles', ' WHERE status=1 AND slug = ? ', [$slug]);
        }
        if ( $article != null) {
            $view = $this->load('articles', $article->id);
            $view->views = $view->views + 1;
            R::store($view);
            return $article;
        } else {
            require_once "404.html";
            die;
        }
    }

    public function popularPosts()
    {
        return R::findAll( 'articles' , ' WHERE status=1 ORDER BY views DESC LIMIT 3 ' );
    }

    public function latestPosts()
    {
        return R::findAll('articles', ' WHERE status=1 ORDER BY id DESC LIMIT 4');
    }

    public function getAuthors()
    {
        return R::getAssoc("SELECT id, username FROM users ");
    }

    public function getOneAuthor()
    {
        $user = R::load('users', self::$user->getUserId());
        return $user->username;
    }

    public function getPrevPost($idArticle)
    {
        if ( self::$auth->isLoggedIn() == true ) {
            $all_id = array_values(R::getAssoc("SELECT id FROM articles"));
        } else {
            $all_id = array_values(R::getAssoc("SELECT id FROM articles WHERE status=1"));
        }
        foreach ($all_id as $k => $v) {
            if ( $idArticle == $v ) {
                $key = $k - 1;
                if ($all_id[$key] != null) {
                    $id = $all_id[$key];
                } else {
                    $id = end($all_id);
                }
                $result = R::getRow("SELECT slug FROM articles WHERE id=:id", [':id' => $id]);
                return $result['slug'];
            }
        }
    }

    public function getNextPost($idArticle)
    {
        if ( self::$auth->isLoggedIn() == true ) {
            $all_id = array_values(R::getAssoc("SELECT id FROM articles"));
        } else {
            $all_id = array_values(R::getAssoc("SELECT id FROM articles WHERE status=1"));
        }
        foreach ($all_id as $k => $v) {
            if ($idArticle == $v) {
                $key = $k + 1;
                if ($all_id[$key] != null) {
                    $id = $all_id[$key];
                } else {
                    $id = $all_id[0];
                }
                $result = R::getRow("SELECT slug FROM articles WHERE id=:id", [':id' => $id]);
                return $result['slug'];
            }
        }
    }

    public function getSlugCategory($slug)
    {
        $result = R::getRow("SELECT category_id FROM articles WHERE slug=:slug", [':slug' => $slug]);
        $result = $result['category_id'];

        $result = R::getRow("SELECT slug FROM categories WHERE id=:id", [':id' => $result]);
        return $result['slug'];
    }

    public function likePosts($category_slug)
    {
        $this->category_id = R::getRow("SELECT * FROM categories WHERE  slug LIKE ? LIMIT 1",
            array($category_slug));
        $post = R::findLike('articles', [
            'category_id' => $this->category_id['id'],
            'status' => 1
        ], ' ORDER BY id DESC');
        if ( $this->category_id != null ) {
            return $post;
        } else {
            require_once "404.html";
            die;
        }
    }

}

