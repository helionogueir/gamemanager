<?php

namespace module\main\driver;

class GetterMapping
{

    public function __construct()
    {
        return $this;
    }

    public function map(array $keys, array $params): array
    {
        $values = array();
        foreach ($keys as $key => $value) {
            $values[$value] = isset($params[$key]) ? $params[$key] : null;
        }
        return $values;
    }

}
