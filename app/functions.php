<?php

/**
 * Returns the date for the given election.
 *
 * @param $election
 * @return mixed
 */
function getElectionDate($election) {
    return config("votelist.elections.{$election}");
}

function getVoteCode($code) {
    return config("votelist.vote_code_map.{$code}");
}

function formatVotingCode($code) {
    return config("votelist.vote_code_map.{$code}");
}

function getVotesByElection($election, $party, $precinct = null) {
    $count = \App\Voter::whereIn($election, config("votelist.vote_types.{$party}"));
    
    if ($precinct) {
        $count->where('pct', $precinct);
    }
    
    return $count->count();
}
