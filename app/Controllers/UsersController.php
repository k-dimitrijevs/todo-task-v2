<?php

namespace App\Controllers;

use App\Auth;
use App\Models\User;
use App\Redirect;
use App\Repositories\MysqlUsersRepository;
use App\Repositories\UsersRepository;
use Ramsey\Uuid\Uuid;

class UsersController
{
    private UsersRepository $usersRepository;

    public function __construct()
    {
        $this->usersRepository = new MysqlUsersRepository();
    }

    public function login(): void
    {
        if (Auth::loggedIn()) Redirect::url('/');
        
        $this->usersRepository->login();
    }

    public function register(): void
    {
        if ($_POST['password'] !== $_POST['password-confirm']) {
            Redirect::url('/invalidRegister');
        } elseif ($this->usersRepository->getByEmail($_POST['email']) > 0) {
            Redirect::url('/invalidEmail');
        }else {
            $user = new User(
                Uuid::uuid4(),
                $_POST['email'],
                $_POST['username'],
                password_hash($_POST['password'], PASSWORD_DEFAULT)
            );

            $this->usersRepository->register($user);
            Redirect::url('/tasks');
        }
    }

    public function logout(): void
    {
        $this->usersRepository->logout();
        require_once "app/Views/users/registerView.template.php";
    }

    public function loginView(): void
    {
        if (Auth::loggedIn()) Redirect::url('/');

        require_once "app/Views/users/loginView.template.php";
    }

    public function registerView(): void
    {
        require_once "app/Views/users/registerView.template.php";
    }

    public function invalidRegisterView(): void
    {
        require_once "app/Views/users/invalidRegister.template.php";
    }

    public function invalidEmailView(): void
    {
        require_once "app/Views/users/invalidEmail.template.php";
    }
}