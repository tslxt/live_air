<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Teacher extends Model
{
	use Notifiable;

	protected $table = 'teachers';

    protected $fillable = [
        'user_id',
    ];

	public function user() 
	{
		return $this->belongsTo('App\User', 'user_id', 'id');
	}

	public function courses()
	{
		return $this->hasMany('App\Course', 'teacher_id', 'id');
	}

	public function public_courses()
	{
		return $this->hasMany('App\Public_course', 'teacher_id', 'id');
	}
}
