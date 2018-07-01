<?php

namespace App\Http\Controllers\Exports;

use App\Exports\CountyWideRepublicanMailingList;
use App\Exports\CountyWideRepublicanMailingListSimple;
use App\Http\Controllers\Controller;

class CountyWideHardRepublicanSimple extends Controller
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
     * @return \App\Exports\CountyWideRepublicanMailingListSimple
     */
    public function export()
    {
        return new CountyWideRepublicanMailingListSimple();
    }
}
