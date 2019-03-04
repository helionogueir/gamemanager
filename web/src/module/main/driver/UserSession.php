<?php

namespace module\main\driver;

use stdClass;
use Exception;

class UserSession
{

    public function __construct()
    {
        if (!session_id())
            @session_start();
        return $this;
    }

    public function create(stdClass $person): bool
    {
        $_SESSION['USER'] = $person;
        return !empty($this->get());
    }

    public function get()
    {
        try {
            if (!empty($_SESSION['USER'])) {
                return (object) array(
                            'personid' => $_SESSION['USER']->personid,
                            'username' => $_SESSION['USER']->username,
                            'nickname' => $_SESSION['USER']->nickname,
                            'fullname' => $_SESSION['USER']->fullname,
                            'email' => $_SESSION['USER']->email
                );
            }
        } catch (Exception $ex) {
            // Put #analytics here!
        }
        return null;
    }

    public function credential()
    {
        try {
            if (!empty($_SESSION['USER']->accesskey) && !empty($_SESSION['USER']->secretkey)) {
                return (object) array(
                            'accesskey' => $_SESSION['USER']->accesskey,
                            'secretkey' => $_SESSION['USER']->secretkey
                );
            }
        } catch (Exception $ex) {
            // Put #analytics here!
        }
        return null;
    }

    public function destroy()
    {
        if (isset($_SESSION['USER']))
            unset($_SESSION['USER']);
        session_destroy();
        return true;
    }

}
