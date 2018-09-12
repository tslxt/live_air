<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $table = 'courses';

    protected $fillable = [
    	'title',
    	'subheading',
    	'subject',
    	'level',
    	'description',
    ];

    public function hasManyLessons()
    {
    	return $this->hasMany('App\Lesson', 'course_id', 'id');
	}
}
