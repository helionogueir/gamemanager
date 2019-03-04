<?php

namespace module\auth\controller;

use module\main\controller\PublicLayer;
use module\auth\usecase\AuthUserByCredentials;

class Login implements PublicLayer
{

    public function __construct(array $params)
    {
        return $this;
    }

    public function render()
    {
        $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
        $password = filter_input(INPUT_POST, 'password', FILTER_UNSAFE_RAW);
        header('Content-Type:application/json');
        echo json_encode((new AuthUserByCredentials())->auth($username, $password));
    }

}
