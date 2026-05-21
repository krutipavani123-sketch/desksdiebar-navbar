<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class login extends Model
{

   public $timestamps = true;
    protected $fillable = ['name', 'email', 'password'];
}
