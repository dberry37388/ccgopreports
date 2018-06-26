<?php

namespace App\Http\Controllers\Exports;

use App\Exports\MasterRepublicanHitlist;
use App\Http\Controllers\Controller;

class MasterRepublicanHitListController extends Controller
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
     * @return \App\Http\Controllers\Exports\MasterRepublicanHitListController
     */
    public function export()
    {
        return new MasterRepublicanHitlist();
    }
}
