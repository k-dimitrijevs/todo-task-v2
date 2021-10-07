<?php

namespace App\Repositories;

use App\Models\Collections\TasksCollection;
use App\Models\Task;
use PDO;
use PDOException;

class MysqlTasksRepository implements TasksRepository
{
    private PDO $connection;

    public function __construct()
    {
        $host = '127.0.0.1';
        $db = 'todo'; // insert db
        $user = ''; // insert username
        $pass = ''; // insert password

        $dsn = "mysql:host=$host;dbname=$db;charset=UTF8";
        try
        {
            $this->connection = new PDO($dsn, $user, $pass);
        } catch (PDOException $e)
        {
            throw new PDOException($e->getMessage(), (int)$e->getCode());
        }
    }

    public function getAll(): TasksCollection
    {
        $sql = "SELECT * FROM tasks ORDER BY created_at DESC";
        $statement = $this->connection->query($sql);
        $tasks = $statement->fetchAll(PDO::FETCH_ASSOC);
        $collection = new TasksCollection();

        foreach ($tasks as $task)
        {
            $collection->add(new Task(
                $task['id'],
                $task['title'],
                $task['created_at'],
            ));
        }

        return $collection;
    }

    public function getOne(string $id): ?Task
    {
        $sql = "SELECT * FROM tasks WHERE id = ?";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute([$id]);
        $task = $stmt->fetch();

        return new Task(
            $task['id'],
            $task['title'],
            $task['created_at'],
        );
    }

    public function save(Task $task): void
    {
        $sql = "INSERT INTO tasks (id, title, created_at) VALUES (?, ?, ?)";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute([
            $task->getId(),
            $task->getTitle(),
            $task->getCreatedAt()
        ]);
    }

    public function delete(Task $task): void
    {
        $sql = "DELETE FROM tasks WHERE id = ?";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute([$task->getId()]);
    }
}