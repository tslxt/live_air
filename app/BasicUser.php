<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;

class BasicUser extends Authenticatable
{
    use HasApiTokens, Notifiable;

    protected $fillable = ['phone'];

    protected $hidden = ['remember_token'];
    
}
