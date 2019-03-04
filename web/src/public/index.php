<?php

try {
    $dirroot = dirname(dirname(__FILE__));
    require_once $dirroot
            . DIRECTORY_SEPARATOR . 'vendor'
            . DIRECTORY_SEPARATOR . 'autoload.php';
    (new \module\main\usecase\RenderRequest())->render($dirroot, $_REQUEST);
} catch (Exception $ex) {
    // Put #analytics here!
    echo '<pre>'
    . 'Fatal Error!'
    . PHP_EOL . $ex->getMessage()
    . PHP_EOL . $ex->getTraceAsString()
    . '</pre>';
}
