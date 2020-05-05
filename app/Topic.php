<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'description', 'subject_id',
    ];

    public function subject(){
        return $this->belongsTo('App\Subject','subject_id','id');
    }
}
