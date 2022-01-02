<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exports\VendasExport;
use App\Imports\VendasImport;
use App\Services\VendaService;
use App\Models\HistoricoImport;

class VendaController extends Controller
{

    protected $vendaService;

    public function __construct(VendaService $vendaService)
    {
        $this->middleware('auth');
        $this->vendaService = $vendaService;
    }

    public function index()
    {
        $vendas = $this->vendaService
            ->where('user_id', auth()->user()->id)
            ->orderBy('data', 'desc')
            ->paginate(10);
        return view('/vendas', compact('vendas'));
    }

    public function viewExportar()
    {
        return view('exportar', [
            'hitorico' => HistoricoImport::where('user_id', auth()->user()->id)
                ->orderBy('created_at', 'desc')
                ->first()
        ]);
    }

    public function exportar(Request $request, VendasExport $vendasExport)
    {
        return $vendasExport->export($request);
    }

    public function viewImportar()
    {
        return view('importar');
    }

    public function importar(Request $request, VendasImport $vendasImport, HistoricoImport $historicoImport)
    {
        if ($vendasImport->import($request)) {
            $historicoImport->create([
                'total_registros' => $this->vendaService->where('user_id', auth()->user()->id)->count(),
                'user_id' => auth()->user()->id
            ]);
            return redirect()->back()->with('success', 'Arquivo importado com sucesso!');
        }
        return redirect()->back()->with('error', 'Dados do arquivo não são válidos!');
    }
}
