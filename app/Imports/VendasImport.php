<?php

namespace App\Imports;

use App\Models\Venda;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Facades\Excel;

class VendasImport implements ToModel
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        if (gettype($row[1]) == 'string') return;
        return new Venda([
            'data' => implode('-', array_reverse(explode('/', $row[0]))),
            'valor_venda' => $row[1],
            'valor_projetado' => $row[2],
            'user_id' => auth()->user()->id
        ]);
    }

    /**
     * import
     *
     * @param  mixed $request
     * @return bool
     */
    public function import(Object $request): bool
    {
        $formato = $request->file('arquivo')->getClientOriginalExtension();
        $vendas = Venda::where('user_id', auth()->user()->id)->get()->toArray();

        Venda::where('user_id', auth()->user()->id)->delete();

        try {
            Excel::import($this, $request->file('arquivo'), null, ucfirst($formato));
        } catch (\Throwable $th) {
            if (!empty($vendas)) {
                foreach ($vendas as $key => $value) {
                    $vendas[$key]['data'] = implode('-', array_reverse(explode('/', $value['data'])));
                    $vendas[$key]['created_at'] = date('Y-m-d', strtotime($value['created_at']));
                    $vendas[$key]['updated_at'] = date('Y-m-d', strtotime($value['updated_at'] ));
                }
            }
            Venda::insert($vendas);
            return false;
        }
        return true;
    }
}
