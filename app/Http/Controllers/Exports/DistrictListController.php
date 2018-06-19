<?php

namespace App\Http\Controllers\Exports;

use App\Exports\DistrictWalkListExport;
use App\Http\Controllers\Controller;
use App\Voter;

class DistrictListController extends Controller
{
    
    /**
     * List of all districts.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('district.index');
    }
    
    /**
     * Exports the first time voter list.
     *
     * @return \App\Exports\DistrictWalkListExport
     */
    public function export($district)
    {
        return new DistrictWalkListExport($district);
    }
    
    /**
     * Displays the District Page
     *
     * @param $district
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($district)
    {
        $voters = Voter::where('pct', $district)
            ->hasVoted()
            ->defaultOrderBy()
            ->paginate(50);
    
        $republicanTotals = [];
        $democratTotals = [];
    
        foreach (array_keys(config('votelist.elections')) as $election) {
            array_push($republicanTotals, getVotesByElection($election, 'republican', $district));
        }
    
        foreach (array_keys(config('votelist.elections')) as $election) {
            array_push($democratTotals, getVotesByElection($election, 'democrat', $district));
        }
        
        return view('district.index', compact('district', 'voters', 'republicanTotals', 'democratTotals'));
    }
}
