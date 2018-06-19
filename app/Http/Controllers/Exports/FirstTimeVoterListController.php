<?php

namespace App\Http\Controllers\Exports;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;

class FirstTimeVoterListController extends Controller
{
    /**
     * FirstTimeVoterListController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    /**
     * Exports the first time voter list.
     *
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function exportAll()
    {
        return Response::download(public_path('exports/2018-first-time-voters-combined.xlsx'), '2018-first-time-voters-combined.xlsx');
    }
    
    /**
     * Exports the first time voter list (democrat).
     *
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function exportDemocrat()
    {
        return Response::download(public_path('exports/2018-first-time-voters-democrat.xlsx'), '2018-first-time-voters-democrat.xlsx');
    }
    
    /**
     * Exports the first time voter list (republican).
     *
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function exportRepublican()
    {
        return Response::download(public_path('exports/2018-first-time-voters-republican.xlsx'), '2018-first-time-voters-republican.xlsx');
    }
}
