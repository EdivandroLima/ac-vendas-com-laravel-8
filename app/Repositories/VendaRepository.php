<?php

namespace App\Repositories;

use App\Contracts\Repositories\VendaRepositoryInterface;
use App\Models\Venda;

class VendaRepository implements VendaRepositoryInterface
{

    protected $model;

    public function __construct(Venda $model) {
        $this->model = $model;
    }

    public function find(string $id): ?object {
        return $this->model->find($id);
    }

	public function getAll(): ?object{
        return $this->model->get();
    }

	public function create(array $data): ?object{
        return $this->model->create($data);
    }

	public function update(array $data): ?object{
        return $this->model->where('id', $data['id'])->update($data);
    }

    public function delete(string $id): bool{
        return $this->model->delete($id);
    }

    public function orderBy(string $column, string $order = 'asc'): ?object{
        return $this->model->orderBy($column, $order);
    }

    public function count(): int{
        return $this->model->count();
    }

    public function sum(string $column)
    {
        return $this->model->sum($column);
    }

    public function where($col, $val)
    {
        return $this->model->where($col, $val);
    }

}
