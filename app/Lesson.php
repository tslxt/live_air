<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    protected $table = 'lessons';

    protected $fillable = [
    	'subject',
        'course_id',
    	'starttime',
    	'terminaltime',
    	'description',
    ];

    public function belongsToCourse()
    {
    	return $this->belongsTo('Course', 'course_id', 'id');
    }
}
