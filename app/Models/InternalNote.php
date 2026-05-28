<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InternalNote extends Model
{

   public $timestamps = true;
    protected $table = "internal_notes";

    protected $fillable = [
        'ticket_id',
        'user_id',
        'note',
    ];

    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
