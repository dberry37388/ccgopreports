<?php

namespace App\Http\Controllers\Exports;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;

class MasterWalkListController extends Controller
{
    /**
     * MasterWalklistController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    /**
     * Exports the master walk list.
     *
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function export()
    {
        return Response::download(public_path('exports/2018-master-walk-list.xlsx'), '2018-master-walk-list.xlsx');
    }
}
