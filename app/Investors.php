<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Investors extends Authenticatable //Model
{

	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'yan_money', 'phone', 'email', 'password', 'hash'
    ];

    /**
     * Get the amount record associated with the investors.
     */
    public function invests()
    {
        return $this->hasMany('App\Invest', 'investors_id');
    }
}
