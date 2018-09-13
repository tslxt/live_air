<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Teacher extends Model
{
	use Notifiable;

	protected $table = 'teachers';

    protected $fillable = [
        'name',
        'user_id',
    ];

	public function user() 
	{
		return $this->belongsTo('App\User', 'user_id', 'id');
	}
}
