<?php

namespace App\Controllers;

use League\Plates\Engine;

class Controller
{
    public static $templates;

    public function __construct(Engine $engine)
    {
        self::$templates = $engine;
    }
}


