<?php

use FastRoute\Dispatcher;
use FastRoute\RouteCollector;


$dispatcher = FastRoute\simpleDispatcher(function(RouteCollector $r) {
    $r->addRoute('GET', '/', ['App\controllers\Blog\MainController', 'index']);
    $r->addRoute('GET', '/{id:\d+}', ['App\controllers\Blog\MainController', 'index']);
    $r->addRoute('GET', '', ['App\controllers\Blog\MainController', 'index']);
    $r->addRoute('GET', '/post/{name:.+}', ['App\controllers\Blog\MainController', 'article']);
    $r->addRoute('POST', '/language', ['App\controllers\Blog\MainController', 'language']);

    $r->addRoute('POST', '/upload', ['App\controllers\Admin\TestController', 'upload']);


    $r->addRoute('GET', '/category/{title}/{id:\d+}', ['App\controllers\Blog\MainController', 'categoryOne']);
    $r->addRoute('GET', '/category/{title}', ['App\controllers\Blog\MainController', 'categoryOne']);

    $r->addRoute('GET', '/author/{title}/{id:\d+}', ['App\controllers\Blog\MainController', 'postsOfAuthor']);
    $r->addRoute('GET', '/author/{title}', ['App\controllers\Blog\MainController', 'postsOfAuthor']);

//    Routes for authentication ->
    $r->addRoute(['GET', 'POST'], '/admin/login', ['App\Controllers\Admin\AdminUserController', 'loginForm']);
    $r->addRoute(['GET', 'POST'], '/admin/login-done', ['App\Controllers\Admin\AdminUserController', 'login']);
    $r->addRoute(['GET', 'POST'],'/admin/sign-up', ['App\Controllers\Admin\AdminUserController', 'signUpForm']);
    $r->addRoute(['GET', 'POST'],'/admin/sign-up-done', ['App\Controllers\Admin\AdminUserController', 'signUp']);
    $r->addRoute('GET','/admin/logout', ['App\Controllers\Admin\AdminUserController', 'logout']);
    $r->addRoute('GET','/verify_email/{name:.+}', ['App\Controllers\Admin\AdminUserController', 'verification']);
    $r->addRoute('GET','/admin/user/edit/{id:\d+}', ['App\Controllers\Admin\AdminUserController', 'edit']);
    $r->addRoute('GET','/admin/user/delete/{id:\d+}', ['App\Controllers\Admin\AdminUserController', 'delete']);
    $r->addRoute('POST','/admin/user/update', ['App\Controllers\Admin\AdminUserController', 'update']);
    $r->addRoute('GET','/admin/users', ['App\Controllers\Admin\AdminUserController', 'index']);


//    Routes for posts ->
    $r->addRoute('GET','/admin', ['App\Controllers\Admin\AdminPostController', 'index']);
    $r->addRoute('GET','/admin/create', ['App\Controllers\Admin\AdminPostController', 'create']);
    $r->addRoute('POST','/admin/store', ['App\Controllers\Admin\AdminPostController', 'store']);
    $r->addRoute('GET','/admin/show', ['App\Controllers\Admin\AdminPostController', 'show']);
    $r->addRoute('GET','/admin/edit/{id:\d+}', ['App\Controllers\Admin\AdminPostController', 'edit']);
    $r->addRoute('POST','/admin/update', ['App\Controllers\Admin\AdminPostController', 'update']);
    $r->addRoute('GET','/admin/destroy/{id:\d+}', ['App\Controllers\Admin\AdminPostController', 'destroy']);

    $r->addRoute('GET','/admin/check', ['App\Controllers\Admin\AdminUserController', 'check']);

//    Routes for categories
    $r->addGroup('/admin/category', function (RouteCollector $r) {
        $r->addRoute('GET','/create', ['App\Controllers\Admin\AdminCategoryController', 'create']);
        $r->addRoute('POST','/store', ['App\Controllers\Admin\AdminCategoryController', 'store']);
        $r->addRoute('GET','/all', ['App\Controllers\Admin\AdminCategoryController', 'index']);
        $r->addRoute('GET','/edit/{id:\d+}', ['App\Controllers\Admin\AdminCategoryController', 'edit']);
        $r->addRoute('POST','/update', ['App\Controllers\Admin\AdminCategoryController', 'update']);
        $r->addRoute('GET','/delete/{id:\d+}', ['App\Controllers\Admin\AdminCategoryController', 'delete']);
    });






    // // {id} must be a number (\d+)
    // $r->addRoute('GET', '/user/delete/{id:\d+}', ['App\controllers\UserController', 'delete']);
    // $r->addRoute('GET', '/user/{id:\d+}', 'get_user_handler');
    // // The /{title} suffix is optional
    // $r->addRoute('GET', '/articles/{id:\d+}[/{title}]', 'get_article_handler');
});


// Fetch method and URI from somewhere
$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

// Strip query string (?foo=bar) and decode URI
if (false !== $pos = strpos($uri, '?')) {
    $uri = substr($uri, 0, $pos);
}
$uri = rawurldecode($uri);
$uri = rtrim($uri, '/');
// if () {
//     trim($uri, '/');
// }
$routeInfo = $dispatcher->dispatch($httpMethod, $uri);
switch ($routeInfo[0]) {
    case Dispatcher::NOT_FOUND:
        include '404.html';
        break;
    case Dispatcher::METHOD_NOT_ALLOWED:
        $allowedMethods = $routeInfo[1];
        // ... 405 Method Not Allowed
        echo "Method Not Allowed";
        break;
    case Dispatcher::FOUND:
        $handler = $routeInfo[1];
        $vars = $routeInfo[2];
        $container->call($routeInfo[1], $routeInfo[2]);
//        d($cont);die;
//        $controller = new $handler[0];
//        call_user_func([$controller, $handler[1]], $vars);
        break;
}
