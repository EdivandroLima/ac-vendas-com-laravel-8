<?php

namespace App\Contracts\Services;

interface VendaServiceInterface
{
    public function find(string $id): ?object;

    public function getAll(): ?object;

    public function create(array $data): ?object;

    public function update(array $data): ?object;

    public function delete(string $id): bool;

    public function orderBy(string $column, string $order = 'asc'): ?object;

    public function count(): int;

    public function getDataHome(): array;

    public function calcVariacaoPercentual($valor1 = 0, $valor2 = 0): string;

    public function getDiaMes(array $data): array;

    public function getMes(string $data): string;

    public function sum(string $column);

    public function valorGanhoHoje(): array;

    public function valorGanhoNoMes(): array;

    public function getDadosMeses(): array;

    public function valorGanhoTotal(): string;

    public function formatMoeda($valor): string;

    public function where($col, $val);
}
