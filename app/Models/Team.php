<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    protected $table = "teams";
    protected $fillable = ['teamName'];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function agents()
    {
        return $this->belongsToMany(User::class);
    }
}
