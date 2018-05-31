<?php
namespace App\Controllers;

use App\Support\Config;

class AdminController extends baseController
{
    public function login()
    {
        $userName = $this->getParam('user', null);
        $password = $this->getParam('password', null);

        if (!$userName || !$password) {
            return view('adminLogin.twig', ['error' => 'Не указан логин и/или пароль!']);
        }

        if (!$this->auth($userName, $password)) {
            return view('adminLogin.twig', ['error' => 'Не верный логин и/или пароль!']);
        }

        isAdmin(true);
        $this->redirect('/');
    }

    public function showLoginForm()
    {
        return view('adminLogin.twig');
    }

    public function logout()
    {
        isAdmin(false);
        $this->redirect('/');
    }

    private function auth(string $userName, string $password):bool
    {
        return strcmp($userName, Config::get('ADMIN_USER_NAME')) == 0 && password_verify($password, Config::get('ADMIN_PASSWORD_HASH'));
    }
}
