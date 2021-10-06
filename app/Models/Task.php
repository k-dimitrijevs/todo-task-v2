<?php

namespace App\Models;

use Carbon\Carbon;

class Task
{
    private string $id;
    private string $title;
    private string $createdAt;

    public function __construct(string $id, string $title, ?string $createdAt = null)
    {
        $this->id = $id;
        $this->title = $title;
        $this->createdAt = $createdAt ?? Carbon::now();
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->getId(),
            'title' => $this->getTitle(),
            'created_at' => $this->getCreatedAt()
        ];
    }
}