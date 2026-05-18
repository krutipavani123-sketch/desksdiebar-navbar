<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoryTeamAgent extends Model
{
     protected $fillable = [
        'category_id',
        'team_id',
        'user_id'
    ];
}
