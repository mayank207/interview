<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;
    protected $table="users";
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','role'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * This can return the user role.
     */
    public function getRole()
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * This can return the note role.
     */
    public function getNote()
    {
        return $this->hasMany(Note::class);
    }
    public function getcreatedAtAttribute($value)
    {
        $date=date_create($value);
        return date_format($date,"d M Y");
    }
}
