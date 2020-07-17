<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AnswerOption extends Model
{
    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'answer_id', 'option_id'
    ];

    public function answer()
    {
        return $this->belongsTo(Answer::class);
    }

    public function option()
    {
        return $this->belongsTo(QuestionOption::class, 'option_id', 'id');
    }
}
