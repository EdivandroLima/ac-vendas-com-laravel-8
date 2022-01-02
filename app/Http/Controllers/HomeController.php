<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\VendaService;

class HomeController extends Controller
{
    protected $vendaService;

    public function __construct(VendaService $vendaService)
    {
        $this->middleware('auth');
        $this->vendaService = $vendaService;
    }

    public function index()
    {
        $data = $this->vendaService->getDataHome();
        return view('home', $data);
    }
}
