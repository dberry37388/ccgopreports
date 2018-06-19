<?php

namespace App\Http\Controllers\Exports;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;

class CrossoverListController extends Controller
{
    /**
     * CrossoverListController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    /**
     * Exports the 2018 crossover list.
     *
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function export()
    {
        return Response::download(public_path('exports/2018-crossover-list.xlsx'), '2018-crossover-list.xlsx');
    }
}
