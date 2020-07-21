<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'answer', 'is_right', 'question_id', 'result_id',
    ];

    public function user()
    {
        return $this->belongsTo(Result::class);
    }

    public function options()
    {
        return $this->hasMany(AnswerOption::class);
    }
}
