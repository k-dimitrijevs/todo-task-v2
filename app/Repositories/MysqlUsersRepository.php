<?php

namespace App\Repositories;

use App\Models\Collections\UsersCollection;
use App\Models\User;
use App\Redirect;
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
            ':password' => $user->getPassword()
        ]);
    }

    public function login(): void
    {

        $user = $this->getByEmail($_POST['email']);

        if ($user !== null && password_verify($_POST['password'], $user->getPassword()))
        {
            $_SESSION['email'] = $_POST['email'];
            Redirect::url('/tasks');
            exit;
        }

        Redirect::url('/login');
    }

    public function logout(): void
    {
        session_destroy();
    }

    public function getByEmail(string $email): ?User
    {
        $sql = "SELECT * FROM users WHERE email = ?";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute([$email]);

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (empty($user)) return null;

        return new User(
            $user['id'],
            $user['email'],
            $user['username'],
            $user['password'],
        );
    }
}
