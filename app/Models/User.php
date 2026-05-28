<?php

namespace App\Models;

use App\Models\Team;
// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Dom\Comment;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Permission\Traits\HasPermissions;
use Laravel\Sanctum\HasApiTokens;
// #[Fillable(['name', 'email', 'password'])]
// #[Hidden(['password', 'remember_token'])]
use Illuminate\Contracts\Auth\MustVerifyEmail;

class User extends Authenticatable implements MustVerifyEmail
{
    public $timestamps = true;
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;
    use HasApiTokens;
    use HasRoles;

    use HasPermissions;
    protected $primaryKey = 'id';
    protected $fillable = ['name', 'email', 'password'];


    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function teams()
    {
        return $this->belongsToMany(Team::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function internalnote()
    {
        return $this->hasMany(InternalNote::class);
        // return $this->hasMany(InternalNote::class, 'user_id');
    }



    public function agentTeams()
    {
        return $this->belongsToMany(Team::class, 'team_agent');
    }

    //one to many
    public function assignedticket()
    {
        return $this->hasMany(Ticket::class, 'assigned_agent_id');
    }

    public function customertickets()
    {
        return $this->hasMany(Ticket::class, 'customer_id');
    }

    public function team()
    {
        return $this->belongsToMany(Team::class, 'team_user');
    }
}
