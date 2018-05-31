<?php

namespace App\Controllers;

abstract class baseController
{
    protected function getParam(string $name, $default = null)
    {
        $params = $_POST + $_GET;

        return $params[$name] ?? $default;
    }

    protected function redirect(string $url)
    {
        header("location: " . $url);
        exit(1);
    }
}
