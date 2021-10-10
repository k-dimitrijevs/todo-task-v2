<?php

namespace App\Controllers;

use App\Models\User;
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
        $this->usersRepository->login();
    }

    public function register(): void
    {
        if ($_POST['password'] !== $_POST['password-confirm']) die('Password and Confirm password should match!');

        $user = new User(
            Uuid::uuid4(),
            $_POST['email'],
            $_POST['username']
        );

        $this->usersRepository->register($user);
        header("Location: /tasks");
    }

    public function logout(): void
    {
        $this->usersRepository->logout();
    }

    public function loginView(): void
    {
        require_once "app/Views/users/loginView.template.php";
    }

    public function registerView(): void
    {
        require_once "app/Views/users/registerView.template.php";
    }
}