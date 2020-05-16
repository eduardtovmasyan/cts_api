<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    /**
     * @var string
     */
    const TYPE_ONE_CHOICE = 'One Choice Question';
    const TYPE_MULTIPLE_CHOICE = 'Multiple Choice Question';
    const TYPE_BOOLEAN = 'True/False Question';
    const TYPE_SHORT_ANSWER = 'Short Answer Question';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'question', 'type', 'topic_id', 'answer',
    ];

    public function options()
    {
      return $this->hasMany(QuestionOption::class);
    }
}
