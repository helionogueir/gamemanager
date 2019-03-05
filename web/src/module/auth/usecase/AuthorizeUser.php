<?php

namespace module\auth\usecase;

use stdClass;
use module\main\UseCase;
use module\main\driver\UserSession;
use module\main\usecase\TranslateToLanguage;

class AuthorizeUser implements UseCase
{

    public function __construct()
    {
        return $this;
    }

    public function authorize($person): stdClass
    {
        $lang = new TranslateToLanguage();
        $response = new stdClass();
        $response->success = false;
        $response->redirect = null;
        $response->message = $lang->translate('auth:login:error', 'auth');
        if (!empty($person)) {
            if ((new UserSession())->create($person)) {
                $response->success = true;
                $response->redirect = '/home/dashboard';
                $response->message = $lang->translate('auth:login:success', 'auth');
            }
        }
        return $response;
    }

}
