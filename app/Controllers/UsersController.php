<?php

namespace App\Controllers;

use App\Auth;
use App\Models\User;
use App\Redirect;
use App\Repositories\MysqlUsersRepository;
use App\Repositories\UsersRepository;
use App\View;
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

        $user = $this->usersRepository->getByEmail($_POST['email']);

        if ($user !== null && password_verify($_POST['password'], $user->getPassword()))
        {
            $_SESSION['email'] = $user->getEmail();
            $_SESSION['username'] = $user->getUsername();
            Redirect::url('/tasks');
            exit;
        }

        Redirect::url('/login');
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

    public function logout(): View
    {
        session_destroy();
        return new View('users/registerView.twig');
    }

    public function loginView(): View
    {
        if (Auth::loggedIn()) Redirect::url('/');
        return new View('users/loginView.twig');
    }

    public function registerView(): View
    {
        return new View('users/registerView.twig');
    }

    public function invalidRegisterView(): View
    {
        return new View('users/invalidRegister.twig');
    }

    public function invalidEmailView(): View
    {
        return new View('users/invalidEmail.twig');
    }
}