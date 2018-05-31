<?php

if (!function_exists('view')) {
    /**
     * Render a view with given data
     * 
     * @param string $view
     * @param array $data
     * @return string
     */
    function view(string $view, array $data = [])
    {
        $data['isAdmin'] = isAdmin();
        static $loader = null;
        static $twig = null;

        if (is_null($twig)) {
            $loader = new Twig_Loader_Filesystem(__DIR__.'/../views');
            $twig = new Twig_Environment($loader);
        }

        return $twig->render($view, $data);
    }
}

if (!function_exists('isAdmin')) {
    function isAdmin(bool $admin = null)
    {
        session_start();
        if (!is_null($admin)) {
            $_SESSION['admin'] = $admin;
        }

        return isset($_SESSION['admin']) && $_SESSION['admin'];
    }
}
