<?php

namespace App\Controllers;

use App\Models\Task;
use App\Repositories\CsvTasksRepository;
use App\Repositories\TasksRepository;
use Ramsey\Uuid\Uuid;

class TasksController
{
    private TasksRepository $tasksRepository;
    public function __construct()
    {
        $this->tasksRepository = new CsvTasksRepository();
    }

    public function index()
    {
        $tasks = $this->tasksRepository->getAll();
        require_once "app/Views/tasks/index.template.php";
    }

    public function create()
    {
        require_once "app/Views/tasks/create.template.php";
    }

    public function store()
    {
        // validate
        
        $task = new Task(
            Uuid::uuid4(),
            $_POST['title']
        );

        $this->tasksRepository->save($task);
        
        header("Location: /tasks");
    }

    public function delete(array $vars)
    {
        $id = $vars['id'] ?? null;
        if ($id == null) header('Location: /');

        $task = $this->tasksRepository->getOne($id);
        if ($task != null)
        {
            $this->tasksRepository->delete($task);
        }

        header('Location: /');
    }

}