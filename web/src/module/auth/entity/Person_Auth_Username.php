<?php

namespace module\auth\entity;

use Exception;
use module\main\Entity;
use module\main\driver\ServiceClient;

class Person_Auth_Username implements Entity
{

    public function __construct()
    {
        return $this;
    }

    public function get(string $username, string $password)
    {
        $data = null;
        try {
            if (!empty($username) && !empty($password)) {
                if ($client = (new ServiceClient('person'))->getClient()) {
                    $response = $client->get("/auth/{$username}", Array(
                        'headers' => Array(
                            'Content-Type' => 'application/json',
                            'Cache-Control' => 'no-cache'
                        ),
                        'body' => json_encode(array(
                            'password' => $password
                        ))
                    ));
                    $metadata = json_decode($response->getBody()->getContents());
                    if (!empty($metadata->data) && $this->validate($metadata->data)) {
                        $data = $metadata->data;
                    }
                }
            }
        } catch (Exception $ex) {
            // Put #analytics here!
        }
        return $data;
    }

    private function validate($person): bool
    {
        $valid = false;
        if (!empty($person->personid) &&
                !empty($person->username) &&
                !empty($person->accesskey) &&
                !empty($person->secretkey) &&
                !empty($person->nickname) &&
                !empty($person->fullname) &&
                !empty($person->email) &&
                !empty($person->genre)) {
            $valid = true;
        }
        return $valid;
    }

}
