<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Test extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'subject_id', 'group_id', 'start', 'end', 'title', 'description',
    ];

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    public function questions()
    {
        return $this->belongsToMany(Question::class, 'test_questions', 'test_id', 'question_id')
        ->withPivot('score')->withTimestamps();
    }
}
