<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TestQuestion extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'question_id', 'test_id', 'score',
    ];
}
