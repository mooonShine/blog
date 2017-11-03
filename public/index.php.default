<?php
ini_set('yaf.name_suffix', 0);
ini_set('yaf.name_separator', '_');
ini_set('session.cookie_domain', '.9xu.com');
define('DEVELOPMENT', true);
define("APP_PATH", realpath(dirname(__FILE__) . '/../application/')); /* 指向public的上一级 */
define("LOG_PATH", APP_PATH . "/../log");
define("BASE_PATH", __DIR__ . '/..');
$app = new Yaf_Application(APP_PATH . "/conf/config.ini");
$app->bootstrap()->run();