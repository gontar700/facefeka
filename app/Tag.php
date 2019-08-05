<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    // this tag shared by many post ?
    public function posts(){
        // sec parameter is a singular name of the in between table
        return $this->morphedByMany('App\Post','taggable');
    }


    // this tag shared by many videos ?
    public function videos(){
        // sec parameter is a singular name of the in between table
        return $this->morphedByMany('App\Video','taggable');
    }
}
