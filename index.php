<?php
require_once __DIR__.DIRECTORY_SEPARATOR.'source/bootstrap.php';

$config = require_once __DIR__.DIRECTORY_SEPARATOR.'config/config.php';

App::instance()->config($config);
App::instance()->run();
