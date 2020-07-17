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

    public function tests()
    {
        return $this->belongsToMany(Test::class, 'test_questions', 'question_id', 'test_id')
                   ->withPivot('score')->withTimestamps();
    }

    public function topic()
    {
        return $this->belongsTo(Topic::class);
    }

    public function isOptional()
    {
        return $this->type === self::TYPE_MULTIPLE_CHOICE
            || $this->type === self::TYPE_ONE_CHOICE;
    }

    public function isCorrectAnswer($answer)
    {
        if ($this->type === self::TYPE_SHORT_ANSWER) {
            return $answer === $this->answer;
        } elseif ($this->type === self::TYPE_BOOLEAN) {
            return boolval($answer) === boolval($this->answer);
        } elseif ($this->type === self::TYPE_MULTIPLE_CHOICE) {
            if (is_array($answer)) {
                $rightOptions = $this->options->where('is_right', true)->pluck('id')->all();
                sort($rightOptions);
                sort($answer);

                return $answer === $rightOptions;
            }

            return false;
        } elseif ($this->type === self::TYPE_ONE_CHOICE) {
            $rightAnswer = $this->options->where('is_right', true)->first()->id;

            return $answer === $rightAnswer;
        }

        return false;
    }
}
