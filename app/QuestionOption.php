<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QuestionOption extends Model
{
    public $table='question_options';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'question_id', 'option', 'is_right',
    ];
    public function options()
    {
      return $this->belongsTo(Question::class);
    }
}
