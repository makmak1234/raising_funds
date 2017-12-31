<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Parameters extends Model
{
    /**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
	    'title', 'parameter'
	];

	public $timestamps = false;
}
