<?php
$basePath = realpath('../../../wp-load.php');

require_once($basePath);

define('DS', DIRECTORY_SEPARATOR);
define('ROOT', realpath(dirname(__FILE__)).DS);
define('APP_PATH', ROOT.'application'.DS);

try {
    require_once APP_PATH.'Autoload.php';
    require_once APP_PATH.'Config.php';

    $registry = Registry::getInstance();
    $registry->request = new Request();

    Bootstrap::run($registry->request);
} catch (Exception $ex) {
    echo $ex->getMessage();
}
