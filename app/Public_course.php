<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Public_course extends Model
{
    protected $table = 'public_courses';

    protected $fillable = [
    	'teacher_id',
    	'title',
    	'image',
    	'courseware',
    	'description',
    ];

    public function teacher()
    {
        return $this->belongsTo('App\Teacher', 'teacher_id', 'id');
    }
}
