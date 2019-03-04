<?php

namespace module\main\usecase;

use stdClass;
use Exception;
use module\main\UseCase;

class SetPathGlobal implements UseCase
{

    public function __construct()
    {
        return $this;
    }

    public function set(string $key, string $value): SetPathGlobal
    {
        global $PATH;
        try {
            if (!($PATH instanceof stdClass)) {
                $PATH = new stdClass();
            }
            if (!empty($key) && !empty($value)) {
                if (file_exists($value)) {
                    $PATH->{$key} = $value;
                }
            }
            if (empty($key) || empty($PATH->{$key})) {
                throw (new Exception("Invalid path value {$value}"));
            }
        } catch (Exception $ex) {
            throw $ex;
        }
        return $this;
    }

}
