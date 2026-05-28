<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{

   public $timestamps = true;
    protected $fillable = ['ticket_id', 'user_id', 'comment', 'is_internal', 'attachment'];

    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
