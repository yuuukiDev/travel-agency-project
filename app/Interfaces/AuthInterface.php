<?php


declare(strict_types=1);

namespace App\Interfaces;

use App\Models\User;

interface AuthInterface
{
    public function create(array $data): User;

    public function getUserByEmail(string $email): User;
}
