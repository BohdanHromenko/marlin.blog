<?php

define("ROOT", dirname(__DIR__));
define("WWW", ROOT . '/public');
define("APP", ROOT . '/app');


define("LIMIT", 3);

require_once ROOT . '/vendor/autoload.php';
require_once ROOT . '/vendor/core/di.php';
require_once ROOT . '/vendor/core/router.php';
