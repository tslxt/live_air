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

    public function lessons()
    {
    	return $this->hasMany('App\Lesson', 'course_id', 'id');
	}

    public function teacher()
    {
        return $this->belongsTo('App\Teacher', 'teacher_id', 'id');
    }

    public function students()
    {
        return $this->belongsToMany('App\Student', 'classes', 'course_id', 'student_id');
    }
}
