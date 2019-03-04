<?php

namespace module\main\controller;

use module\main\driver\MustacheEngine;
use module\main\controller\PublicLayer;
use module\main\usecase\TranslateToLanguage;

class HttpPage implements PublicLayer
{

    public function __construct(array $params)
    {
        return $this;
    }

    public function render()
    {
        global $PATH;
        $code = empty($params[0]) ? 404 : $params[0];
        header("HTTP/1.0 {$code}");
        $m = new MustacheEngine(array(
            'loader' => $PATH->main . DIRECTORY_SEPARATOR . 'view',
        ));
        echo $m->render("httppage", Array(
            'statusCode' => $code,
            'statusMessage' => (new TranslateToLanguage())->translate("http:{$code}")
        ));
    }

}
