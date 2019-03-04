<?php

namespace module\main\usecase;

use module\main\UseCase;

class SetDebug implements UseCase
{

    public function __construct()
    {
        return $this;
    }

    public function php(): bool
    {
        global $CFG;
        $CFG->environment->debug = empty($CFG->environment->debug) ? false : true;
        if ($CFG->environment->debug) {
            error_reporting(E_ALL | E_STRICT);
            ini_set('display_errors', true);
        }
        return $CFG->environment->debug;
    }

}
