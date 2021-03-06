<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    // it means he knows he communicating with table posts because of the name of the class
    // if it was postadmin . we need to ad protected table = 'posts'

    use SoftDeletes;

    protected $fillable = [
        'title',
        'content'
    ];

    public function user(){

          return $this->belongsTo('App\User');
    }

    public function photos(){
        return $this->morphMany('App\Photo','imageable');
    }

    // get all tags of a post

    public function tags(){
        return $this->morphToMany('App\Tag','taggable');
    }
}
