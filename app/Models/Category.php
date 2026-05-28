<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'name',
        'team_id'
    ];
    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }

    // public function team()
    // {
    //     return $this->belongsTo(Team::class);
    // }
public function team()
{
    return $this->hasMany(Team::class);
}

    }


