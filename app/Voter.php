<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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
    
    
}
