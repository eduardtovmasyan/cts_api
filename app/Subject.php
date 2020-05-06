<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'description',
    ];
    
    public function topics()
    {
        return $this->hasMany('App\Topic', 'subject_id', 'id');
    }
}
