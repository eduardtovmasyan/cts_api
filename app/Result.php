<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Result extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'total', 'user_id', 'test_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function Test()
    {
        return $this->belongsTo(Test::class);
    }
}
