<?php

namespace App\Http\Controllers\Exports;

use App\Exports\CountyWideRepublicanMailingList;
use App\Http\Controllers\Controller;

class CountyWideRepublicanMailingListController extends Controller
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
     * @return \App\Exports\CountyWideRepublicanMailingList
     */
    public function export()
    {
        return new CountyWideRepublicanMailingList();
    }
}
