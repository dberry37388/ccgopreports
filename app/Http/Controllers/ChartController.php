<?php

namespace App\Http\Controllers;

class ChartController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $totals = [];
        
        $totals['countywide'] = $this->getTotals();
        
        for($i = 1; $i <= 21; $i++) {
            $totals['district_' . $i] = $this->getTotals($i);
        }
        
        return view('charts.index', compact('totals'));
    }
    
    /**
     * @param null $district
     * @return array
     */
    protected function getTotals($district = null)
    {
        $republicanTotals = [];
        $democratTotals = [];
    
        foreach (array_keys(config('votelist.elections')) as $election) {
            array_push($republicanTotals, getVotesByElection($election, 'republican', $district));
        }
    
        foreach (array_keys(config('votelist.elections')) as $election) {
            array_push($democratTotals, getVotesByElection($election, 'democrat', $district));
        }
        
        if (empty($district)) {
            $div = 'countywide';
            $label = 'County-Wide';
        } else {
            $div = 'district_'.$district;
            $label = "District {$district}";
        }
    
        return [
            'div' => $div,
            'label' => $label,
            'republican' => $republicanTotals,
            'democrat' => $democratTotals
        ];
    }
}
