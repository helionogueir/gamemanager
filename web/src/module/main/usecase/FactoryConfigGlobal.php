<?php

namespace module\main\usecase;

use module\main\UseCase;
use module\main\usecase\SetDebug;

class FactoryConfigGlobal implements UseCase
{

    public function __construct()
    {
        return $this;
    }

    public function factory()
    {
        global $CFG, $PATH;
        $filename = $PATH->dirroot
                . DIRECTORY_SEPARATOR . 'config.json';
        if (file_exists(($filename))) {
            $cfg = json_decode(file_get_contents($filename));
            if (JSON_ERROR_NONE === json_last_error()) {
                $CFG = $cfg;
                $variables = array(
                    'environment' => array('default', 'charset', 'lang')
                );
                foreach ($variables as $key => $variable) {
                    if (empty($CFG->environment->default)) {
                        throw (new \Exception("Variable {$$key}:{$variable} not found in config.json"));
                    }
                }
                (new SetDebug())->php();
            }
        }
    }

}
