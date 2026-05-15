<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;

class Ticket extends Model
{
    // use HasRoles;

    protected $table = 'tickets';
    protected $fillable = [
        'subject',
        'description',
        'priority',
        'category',
        'attachment',
        'status'
    ];
}
