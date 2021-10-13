<?php

namespace App\Controllers;

use App\Models\Task;
use App\Redirect;
use App\Repositories\CsvTasksRepository;
use App\Repositories\MysqlTasksRepository;
use App\Repositories\TasksRepository;
use App\View;
use Ramsey\Uuid\Uuid;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class TasksController
{
    private TasksRepository $tasksRepository;

    public function __construct()
    {
        $this->tasksRepository = new MysqlTasksRepository();
    }

    public function index(): View
    {
        $tasks = $this->tasksRepository->getAll();

        return new View('tasks/index.twig', [
            'tasks' => $tasks
        ]);
    }

    public function create()
    {
        return new View('tasks/create.twig');
    }

    public function store()
    {
        // validate
        
        $task = new Task(
            Uuid::uuid4(),
            $_POST['title']
        );

        $this->tasksRepository->save($task);

        Redirect::url('/tasks');
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

        Redirect::url('/');
    }

}