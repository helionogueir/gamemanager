<?php

namespace module\main;

interface Controller
{

    public function __construct(array $params);

    public function render();
}
