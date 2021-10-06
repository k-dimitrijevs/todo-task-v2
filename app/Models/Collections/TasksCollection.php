<?php

namespace App\Models\Collections;

use App\Models\Task;

class TasksCollection
{
    private array $tasks = [];

    public function __construct(array $tasks = [])
    {
        foreach ($tasks as $task) $this->add($task);
    }

    public function add(Task $task)
    {
        $this->tasks[$task->getId()] = $task;
    }

    public function getTasks(): array
    {
        return $this->tasks;
    }
}