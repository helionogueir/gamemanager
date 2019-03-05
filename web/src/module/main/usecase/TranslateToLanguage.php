<?php

namespace module\main\usecase;

use stdClass;
use Exception;
use module\main\UseCase;

class TranslateToLanguage implements UseCase
{

    public function __construct()
    {
        return $this;
    }

    public function translate(string $name, string $package = 'main', array $variables = array()): string
    {
        $language = '';
        try {
            if ($pkg = $this->loadPackage($package)) {
                if (!empty($pkg->{$name})) {
                    $language = $this->replaceVariable($pkg->{$name}, $variables);
                }
            }
            return $language;
        } catch (Exception $ex) {
            // Put #analytics here!
        }
        return $language;
    }

    private function loadPackage(string $package): stdClass
    {
        global $CFG, $PATH;
        $data = new stdClass();
        $module = empty($package) ? 'main' : $package;
        $filename = $PATH->dirroot
                . DIRECTORY_SEPARATOR . 'module'
                . DIRECTORY_SEPARATOR . $module
                . DIRECTORY_SEPARATOR . 'lang'
                . DIRECTORY_SEPARATOR . "{$CFG->environment->lang}.json";
        if (file_exists($filename)) {
            $metadata = json_decode(file_get_contents($filename));
            if (JSON_ERROR_NONE === json_last_error() && ($metadata instanceof stdClass)) {
                $data = $metadata;
            }
        }
        return $data;
    }

    private function replaceVariable(string $text, array $variables): string
    {
        if (!empty($variables)) {
            foreach ($variables as $name => $value) {
                $pattern = "/^(.*?)(\:\{{$name}\})(.*?)$/";
                if (preg_match($pattern, $text)) {
                    $text = preg_replace($pattern, "$1{$value}$3", $text);
                }
            }
        }
        return $text;
    }

}
