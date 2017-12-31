<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invest extends Model
{
    /**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
	    'amount', 'amount_got', 'amount_type', 'time_got', 'label', 'full_answer', 'investors_id', 'term', 'accept',
	];

	/**
     * Get the amount record associated with the investors.
     */
    public function investors()
    {
        return $this->belongsTo('App\Investors');
    }
}
