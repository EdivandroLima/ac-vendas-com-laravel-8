<?php

namespace App\Exports;

use App\Models\Venda;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithColumnWidths;

class VendasExport implements WithStyles, FromArray, WithColumnWidths
{

    protected $data_entre = ['1970-01-01', '2050-01-01'];

    /**
     * array
     *
     * @return array
     */
    public function array(): array
    {
        $vendas = Venda::where('user_id', auth()->user()->id)
            ->whereBetween('data', $this->data_entre)
            ->get(['data', 'valor_venda', 'valor_projetado'])
            ->toArray();

        $cabecalho = [['Data', 'Valor de vendas', 'Valor projetado']];

        return array_merge($cabecalho, $vendas);
    }

    /**
     * styles
     *
     * @param  mixed $sheet
     * @return array
     */
    public function styles(Worksheet $sheet): array
    {
        return [
            1 => [
                'font' => ['bold' => true],
            ],
        ];
    }

    /**
     * Largura das colunas
     *
     * @return array
     */
    public function columnWidths(): array
    {
        return [
            'A' => 16,
            'B' => 16,
            'C' => 16,
        ];
    }

    /**
     * export
     *
     * @param object $request
     * @return void
     */
    public function export(Object $request)
    {

        if (!empty($request->data_inicio) && !empty($request->data_final)) {
            $this->data_entre = [
                $request->data_inicio,
                $request->data_final
            ];
        }

        return Excel::download(
            $this,
            "acompanhamento_vendas." . strtolower($request->formato),
            ucfirst(strtolower(str_replace('PDF', 'DOMPDF', $request->formato)))
        );
    }
}
