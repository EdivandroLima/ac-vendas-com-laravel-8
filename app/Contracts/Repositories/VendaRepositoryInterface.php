<?php

namespace App\Contracts\Repositories;

interface VendaRepositoryInterface
{
    public function find(string $id): ?object;

    public function getAll(): ?object;

    public function create(array $data): ?object;

    public function update(array $data): ?object;

    public function delete(string $id): bool;

    public function orderBy(string $column, string $order = 'asc'): ?object;

    public function count(): int;

    public function sum(string $column);

    public function where($col, $val);

}
