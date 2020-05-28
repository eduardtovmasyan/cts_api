<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    /**
     * @var string
     */
    const TYPE_ADMIN = 'admin';
    const TYPE_TESTEE = 'testee';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'phone', 'type', 'is_active', 'group_id',
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
     * Filter the query by the user type, keep only admins.
     *
     * @param  mixed  $query
     * @return mixed
     */
    public function scopeWhichAdmin($query)
    {
        return $query->where('type', self::TYPE_ADMIN);
    }

    /**
     * Filter the query by the user type, keep only admins.
     *
     * @param  mixed  $query
     * @return mixed
     */
    public function scopeWhichTestee($query)
    {
        return $query->where('type', self::TYPE_TESTEE);
    }

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    public function results()
    {
        return $this->hasMany(Result::class);
    }
}
