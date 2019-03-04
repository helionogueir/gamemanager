<?php

namespace module\auth\controller;

use module\main\driver\UserSession;
use module\main\controller\PublicLayer;

class Logout implements PublicLayer
{

    public function __construct(array $params)
    {
        return $this;
    }

    public function render()
    {
        (new UserSession())->destroy();
        header('location:/');
    }

}
