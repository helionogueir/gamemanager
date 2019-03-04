<?php

namespace module\auth\usecase;

use stdClass;
use module\main\UseCase;
use module\main\driver\UserSession;
use module\auth\entity\Person_Auth_Username;
use module\main\usecase\TranslateToLanguage;

class AuthUserByCredentials implements UseCase
{

    public function __construct()
    {
        return $this;
    }

    public function auth($username, $password): stdClass
    {
        $lang = new TranslateToLanguage();
        $response = new stdClass();
        $response->success = false;
        $response->redirect = null;
        $response->message = $lang->translate('auth:login:error', 'auth');
        if (!empty($username) && !empty($password)) {
            if ($person = (new Person_Auth_Username())->get($username, $password)) {
                if ((new UserSession())->create($person)) {
                    $response->success = true;
                    $response->redirect = '/admin';
                    $response->message = $lang->translate('auth:login:success', 'auth');
                }
            }
        }
        return $response;
    }

}
