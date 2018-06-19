<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Voter extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'state_id',
        'first_name',
        'last_name',
        'title',
        'house_number',
        'street_address',
        'address',
        'address2',
        'city',
        'state',
        'zip',
        'phone',
        'pct',
        'pct_sub',
        'pct_nbr',
        'mail',
        'mail_city',
        'mail_state',
        'mail_zip',
        'e_1',
        'e_2',
        'e_3',
        'e_4',
        'e_5',
        'e_6',
        'e_7',
        'e_8',
        'e_9',
        'e_10',
        'e_11',
        'e_12',
        'e_13',
        'e_14',
        'e_15',
        'latitude',
        'longitude'
    ];
    
    /**
     * Only shows voters who have voted in the last 4 elections.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder
     */
    public function scopeHasVoted(Builder $query)
    {
        return $query->where('total_votes', '>=', 1);
    }
    
    /**
     * Default order by precinct, street, house number.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeDefaultOrderBy(Builder $query)
    {
        return $query
            ->orderBy('pct', 'asc')
            ->orderBy('street_address', 'asc')
            ->orderBy('house_number', 'asc')
            ->orderBy('last_name', 'asc');
    }
    
    /**
     * Query builder scope to list neighboring locations
     * within a given distance from a given location
     *
     * @param  \Illuminate\Database\Query\Builder  $query  Query builder instance
     * @param  mixed                              $lat    Lattitude of given location
     * @param  mixed                              $lng    Longitude of given location
     * @param  integer                            $radius Optional distance
     * @param  string                             $unit   Optional unit
     *
     * @return \Illuminate\Database\Query\Builder          Modified query builder
     */
    public function scopeDistance($query, $lat, $lng, $radius = 3, $unit = "mi")
    {
        $unit = ($unit === "km") ? 6378.10 : 3963.17;
        $lat = (float) $lat;
        $lng = (float) $lng;
        $radius = (double) $radius;
        
        return $query->having('distance','<=',$radius)
            ->select(DB::raw("*,
                            ($unit * ACOS(COS(RADIANS($lat))
                                * COS(RADIANS(latitude))
                                * COS(RADIANS($lng) - RADIANS(longitude))
                                + SIN(RADIANS($lat))
                                * SIN(RADIANS(latitude)))) AS distance")
            )->orderBy('distance','asc');
    }
    
    
}
