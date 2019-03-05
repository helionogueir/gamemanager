<?php

namespace module\main\usecase;

use module\main\UseCase;
use module\main\driver\MustacheEngine;
use module\main\usecase\TranslateToLanguage;

class HttpPage implements UseCase
{

    public function __construct()
    {
        return $this;
    }

    public function display(int $statusCode)
    {
        header("HTTP/1.0 {$statusCode}");
        global $PATH;
        $m = new MustacheEngine(array(
            'loader' => $PATH->main . DIRECTORY_SEPARATOR . 'view',
        ));
        echo $m->render("httppage", Array(
            'statusCode' => $statusCode,
            'statusMessage' => (new TranslateToLanguage())->translate("http:{$statusCode}")
        ));
    }

}
