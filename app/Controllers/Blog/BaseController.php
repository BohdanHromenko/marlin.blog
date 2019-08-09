<?php


namespace App\Controllers\Blog;

use App\Controllers\Controller;
use App\Models\Blog\MainModel;
use League\Plates\Engine;
use Pagerfanta\Adapter\ArrayAdapter;
use Pagerfanta\Pagerfanta;

class BaseController extends Controller
{
//    protected static $arrayAdapter;
//    protected static $pagerfanta;

    protected static $main;
    public function __construct(Engine $engine, MainModel $main/*, ArrayAdapter $arrayAdapter, Pagerfanta $pagerfanta*/)
    {
        self::$main = $main;
//        self::$arrayAdapter = $arrayAdapter;
//        self::$pagerfanta = $pagerfanta;
        parent::__construct($engine);

    }

}
