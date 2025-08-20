<?php

declare(strict_types=1);

namespace App\Contracts;

interface IBaseRepository
{
    public function all(): array;
    public function find($id): array;
    public function create(array $data): object;
    public function update ($id, array $data): ?object;
    public function delete ($id): bool; 
}