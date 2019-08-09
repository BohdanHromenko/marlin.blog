<?php

namespace App\Controllers\Blog;


use App\Models\Admin\UserModel;
use App\Models\Blog\MainModel;
use League\Plates\Engine;


class MainController extends BaseController
{
    private $id_post;
    protected $number_page;
    private $category_slug;
    protected $number_page_in_category;
    private $slug_author;
    public static $user;

	public function __construct(Engine $engine, MainModel $main, UserModel $user)
    {
        parent::__construct($engine, $main);
        if (!$_SESSION['USER_LANGUAGE']) self::setLang(substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2));
        $array_uri = explode('/', $_SERVER['REQUEST_URI']);

        self::$user                     = $user;
        $this->id_post                  = $array_uri[3];
        $this->number_page              = $array_uri[1];
        $this->category_slug            = $array_uri[2];
        $this->number_page_in_category  = $array_uri[3];
        $this->slug_author              = $array_uri[2];
    }

    public function index()
	{

        $langTitle = self::$user->getLanguageTitle();
        $langDesc = self::$user->getLanguageDescription();

        $articles       = self::$main->index($this->number_page);
	    $categories     = self::$main->categories();
	    $amountPages    = (int)self::$main->amountPages();
	    $numberOfPages  = (int)$this->number_page;
	    $authors        = self::$main->getAuthors();

	    echo self::$templates->render('Blog/home', compact('articles', 'categories',
            'amountPages', 'numberOfPages', 'authors', 'langTitle', 'langDesc'));
	}

	public function article()
	{
        $langTitle = self::$user->getLanguageTitle();
        $langDesc = self::$user->getLanguageDescription();
        $post           = self::$main->article($this->id_post);
        $author         = self::$main->getOneAuthor();

        $prevPost = self::$main->article(self::$main->getPrevPost($post->id));
        $nextPost = self::$main->article(self::$main->getNextPost($post->id));

        $prevSlugCategory = self::$main->getSlugCategory(self::$main->getPrevPost($post->id));
        $nextSlugCategory = self::$main->getSlugCategory(self::$main->getNextPost($post->id));

        $likePost = self::$main->likePosts(self::$main->getSlugCategory($this->id_post));
        $thisSlugCategory = self::$main->getSlugCategory($this->id_post);

        echo self::$templates->render('Blog/article', compact('post', 'author', 'likePost',
            'langTitle', 'langDesc', 'prevPost', 'nextPost', 'prevSlugCategory', 'nextSlugCategory', 'thisSlugCategory'));
	}

	public function categoryOne()
    {
        $langTitle = self::$user->getLanguageTitle();
        $langDesc = self::$user->getLanguageDescription();

        $articles       = self::$main->categoryOne($this->category_slug, $this->number_page_in_category);
        $categories     = self::$main->categories();
        $amountPages    = (int)self::$main->amountPagesWhereCategory();
        $numberOfPages  = (int)$this->number_page_in_category;
        $authors        = self::$main->getAuthors();


        echo self::$templates->render('Blog/category',
            compact('articles', 'categories', 'amountPages', 'numberOfPages', 'authors',
                'langTitle', 'langDesc'));
    }

    public function postsOfAuthor()
    {
        $langTitle = self::$user->getLanguageTitle();
        $langDesc = self::$user->getLanguageDescription();

        $id             = str_replace('_', ' ', $this->slug_author);

        $articles       = self::$main->postsOfAuthor($id, $this->number_page_in_category);
        $categories     = self::$main->categories();
        $amountPages    = (int)self::$main->amountPagesWhereAuthor($id);
        $numberOfPages  = (int)$this->number_page_in_category;
        $authors        = self::$main->getAuthors();

        echo self::$templates->render('Blog/byAuthors',
            compact('articles', 'categories', 'amountPages', 'numberOfPages', 'authors',
                'langTitle', 'langDesc'));
    }

	public static function popularPosts()
    {
        return self::$main->popularPosts();
    }

    public static function categories()
    {
        return self::$main->categories();
    }

    public static function latestPosts()
    {
        return self::$main->latestPosts();
    }

    public function setLang($var)
    {
        if (!in_array($var, array('en', 'pl', 'ru', 'de'))) $var = 'en';
        $_SESSION['USER_LANGUAGE'] = $var;
    }

    public function language()
    {
        $_SESSION['USER_LANGUAGE'] = $_POST['lang'];
        header('Location: ' . $_SERVER['HTTP_REFERER']);
    }

    public function getLanguageTitle()
    {
        return self::$user->getLanguageTitle();
    }

    public function getLanguageDescription()
    {
        return self::$user->getLanguageDescription();
    }

}
