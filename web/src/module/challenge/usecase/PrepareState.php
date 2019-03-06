<?php

namespace module\challenge\usecase;

use module\main\UseCase;
use module\main\usecase\TranslateToLanguage;

class PrepareState implements UseCase
{

    private $lang = null;

    public function __construct()
    {
        $this->lang = new TranslateToLanguage();
        return $this;
    }

    public function prepare(string $stagename, array $values): array
    {
        return array(
            'tag' => $stagename,
            'title' => $this->lang->translate("{$stagename}:title", 'challenge'),
            'values' => $values
        );
    }

}
