<?php

namespace App\Repositories;

use App\Models\Collections\UsersCollection;
use App\Models\User;
use PDO;
use PDOException;

class MysqlUsersRepository implements UsersRepository
{

    private PDO $connection;

    public function __construct()
    {
        require_once "config.php";

        $dsn = "mysql:host=$host;dbname=$db;charset=UTF8";
        try
        {
            $this->connection = new PDO($dsn, $user, $pass);
        } catch (PDOException $e)
        {
            throw new PDOException($e->getMessage(), (int)$e->getCode());
        }
    }

    public function register(User $user): void
    {
        $sql = "INSERT INTO users (id, email, username, password) VALUES (:id, :email, :username, :password)";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute([
            ':id' => $user->getId(),
            ':email' => $user->getEmail(),
            ':username' => $user->getUsername(),
            ':password' => md5($_POST['password'])
        ]);
    }

    public function login(): void
    {
        $password = md5($_POST['password']);

        $sql = "SELECT * FROM users WHERE email = :email AND password = :password";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute([
           'email' => $_POST['email'],
           'password' => $password
        ]);
        
        if ($stmt->rowCount() > 0)
        {
            $_SESSION['email'] = $_POST['email'];
            header('Location: /tasks');
        } else {
            header('Location: /login');
        }
    }

    public function logout(): void
    {
        session_destroy();
    }
}
