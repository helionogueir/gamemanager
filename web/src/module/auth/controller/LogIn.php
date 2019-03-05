<?php

namespace module\auth\controller;

use module\main\usecase\Route;
use module\auth\usecase\AuthorizeUser;
use module\main\controller\PublicLayer;
use module\auth\entity\Person_Auth_Username;

class LogIn implements PublicLayer
{

    public function __construct(Route $route)
    {
        return $this;
    }

    public function display()
    {
        $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
        $password = filter_input(INPUT_POST, 'password', FILTER_UNSAFE_RAW);
        $person = (new Person_Auth_Username())->get($username, $password);
        header('Content-Type:application/json');
        echo json_encode((new AuthorizeUser())->authorize($person));
    }

}
