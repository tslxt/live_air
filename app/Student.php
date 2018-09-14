<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $table = 'students';

    protected $fillable = [
        'user_id',
    ];

	public function user() 
	{
		return $this->belongsTo('App\User', 'user_id', 'id');
	}

	public function courses()
	{
		return $this->belongsToMany('App\Course', 'classes', 'student_id', 'course_id');
	}
}
