<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Investors extends Model
{

	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'yan_money', 'phone', 'email', 'password',
    ];

    /**
     * Get the amount record associated with the investors.
     */
    public function invests()
    {
        return $this->hasMany('App\Invest', 'investors_id');
    }
}
