<?php

namespace App\Services;

use App\Models\Venda;
use App\Models\HistoricoImport;
use App\Contracts\Services\VendaServiceInterface;
use App\Contracts\Repositories\VendaRepositoryInterface;

class VendaService implements VendaServiceInterface
{

    protected $repository;

    public function __construct(VendaRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function find(string $id): ?object
    {
        return $this->repository->find($id);
    }

    public function getAll(): ?object
    {
        return $this->repository->getAll();
    }

    public function create(array $data): ?object
    {
        return $this->repository->create($data);
    }

    public function update(array $data): ?object
    {
        return $this->repository->update($data);
    }

    public function delete(string $id): bool
    {
        return $this->repository->delete($id);
    }

    public function orderBy(string $column, string $order = 'asc'): ?object
    {
        return $this->repository->orderBy($column, $order);
    }

    public function sum(string $column)
    {
        return $this->repository->sum($column);
    }

    public function count(): int
    {
        return $this->repository->count();
    }
    public function where($col, $val)
    {
        return $this->repository->where($col, $val);
    }

    /**
     * getDataHome
     *
     * @return array
     */
    public function getDataHome(): array
    {
        $vendasPaginate = $this->where('user_id', auth()->user()->id)
            ->orderBy('data', 'desc')
            ->paginate(30);

        // dados para o gráfico
        $dadosVendas = array_reverse($vendasPaginate->toArray()['data']);
        $dadosVendas = [
            'datas' => $this->getDiaMes(array_column($dadosVendas, 'data')),
            'valor_venda' => array_column($dadosVendas, 'valor_venda'),
            'valor_projetado' => array_column($dadosVendas, 'valor_projetado'),
        ];

        $dadosMes = $this->getDadosMeses();
        $valorGanhoNoMes = $this->valorGanhoNoMes();
        $valorGanhoHoje = $this->valorGanhoHoje();
        $valorGanhoTotal = $this->valorGanhoTotal();

        return [
            'vendasPaginate' => $vendasPaginate,
            'dadosMes' => json_encode($dadosMes),
            'dadosVendas' => json_encode($dadosVendas),
            'valorGanhoTotal' => $valorGanhoTotal,
            'valorGanhoNoMes' => $valorGanhoNoMes,
            'valorGanhoHoje' => $valorGanhoHoje,
            'historico' => HistoricoImport::where('user_id', auth()->user()->id)
                ->orderBy('created_at', 'desc')
                ->limit(9)->get(),
        ];
    }

    /**
     * calcular a variação percentual
     *
     * @param  mixed $valor1
     * @param  mixed $valor2
     * @return string
     */
    public function calcVariacaoPercentual($valor1 = 0, $valor2 = 0): string
    {
        $maior = $valor1 > $valor2 ? $valor1 : $valor2;
        $menor = $valor1 < $valor2 ? $valor1 : $valor2;
        $menor = $menor ?: $maior / 2;

        $porcentgem = intval((($maior - $menor) / ($menor ?: 1)) * 100);

        if ($valor1 > $valor2) {
            $porcentgem = "+$porcentgem%";
        } else {
            $porcentgem = "-$porcentgem%";
        }

        return $porcentgem;
    }

    /**
     * Formatar datas de array no formato 01/02/2022 para 01/02
     *
     * @param mixed $data -> ['01/02/2022', '02/02/2022']
     * @return array
     */
    public function getDiaMes(array $data): array
    {
        $dm = function ($valor) {
            return explode('/', $valor)[0] . '/' . explode('/', $valor)[1];
        };
        return array_map($dm, $data);
    }

    /**
     * getMes
     *
     * @param  mixed $data -> 01-02-2022
     * @return string Fev
     */
    public function getMes(string $data): string
    {
        $mes = intval(explode('-', $data)[1]);
        $meses = ['', 'Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'];

        return $meses[$mes];
    }

    /**
     * valorGanhoHoje
     *
     * @return array
     */
    public function valorGanhoHoje(): array
    {
        $vendas = $this->where('user_id', auth()->user()->id)
            ->orderBy('data', 'desc')
            ->offset(0)
            ->limit(2)
            ->get();

        if (count($vendas) >= 2) {
            $valorHoje = substr_count($vendas[0]->data, date('Y-m-d')) ? $vendas[0]->valor_venda : 0;
            $valorOntem = substr_count($vendas[1]->data, date('Y-m-d', strtotime('- 1 day'))) ? $vendas[1]->valor_venda : 0;
        } else {
            $valorHoje = 0;
            $valorOntem = 0;
        }

        $valorGanhoHoje = [
            'valor' => $this->formatMoeda($valorHoje),
            'porcentagem' => $this->calcVariacaoPercentual($valorHoje, $valorOntem)
        ];

        return $valorGanhoHoje;
    }

    /**
     * valorGanhoNoMes
     *
     * @return array
     */
    public function valorGanhoNoMes(): array
    {
        $dadosMes = $this->getDadosMeses();

        $valorEsteMes = end($dadosMes['valor']);
        $valorMesPassado = prev($dadosMes['valor']);

        $valorGanhoNoMes = [
            'valor' => $this->formatMoeda($valorEsteMes),
            'porcentagem' => $this->calcVariacaoPercentual($valorEsteMes, $valorMesPassado)
        ];

        return $valorGanhoNoMes;
    }

    /**
     * getDadosMeses
     *
     * @return array
     */
    public function getDadosMeses(): array
    {
        $vendasMes = $this->where('user_id', auth()->user()->id)
            ->orderBy('data')
            ->get(['data', 'valor_venda'])
            ->groupBy(function ($data) {
                return $data->data->format('Y-m');
            })->toArray();

        $dadosMes = ['meses' => [], 'valor' => []];

        foreach ($vendasMes as $key => $value) {
            array_push($dadosMes['meses'], $this->getMes($key));
            array_push($dadosMes['valor'], array_sum(array_column($value, 'valor_venda')));
        }
        return $dadosMes;
    }

    /**
     * valorGanhoTotal
     *
     * @return string
     */
    public function valorGanhoTotal(): string
    {
        $valorTotal = $this->where('user_id', auth()->user()->id)->sum('valor_venda');
        return $this->formatMoeda($valorTotal);
    }

    /**
     * formatMoeda
     *
     * @param  mixed $valor
     * @return string Ex -> R$ 1.000,00
     */
    public function formatMoeda($valor): string
    {
        return 'R$ ' . number_format($valor, 2, ',', '.');
    }
}
