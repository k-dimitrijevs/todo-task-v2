<?php

namespace App\Models;

class User
{
    private string $id;
    private string $email;
    private string $username;

    public function __construct(string $id, string $email, string $username)
    {
        $this->id = $id;
        $this->email = $email;
        $this->username = $username;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getUsername(): string
    {
        return $this->username;
    }
}