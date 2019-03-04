<?php

namespace module\main\driver;

use Exception;
use Firebase\JWT\JWT;
use module\main\driver\UserSession;

class Authentication
{

    public function __construct()
    {
        return $this;
    }

    public function encode(): string
    {
        $token = '';
        try {
            if ($credential = (new UserSession())->credential()) {
                $payload = array(
                    "accesskey" => $credential->accesskey,
                    "exp" => time() + 5,
                    "iat" => time()
                );
                $token = JWT::encode($payload, $credential->secretkey, 'HS256');
            }
        } catch (Exception $ex) {
            // Put #analytics here!
        }
        return $token;
    }

}
