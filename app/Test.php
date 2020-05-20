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
        'subject_id', 'group_id', 'start', 'end',
    ];

    public function subject()
    {
        return $this->hasOne('App\Subject');
    }

    public function group()
    {
        return $this->hasOne('App\Group');
    }
}
