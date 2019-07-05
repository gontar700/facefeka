<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PostAdmin extends Model
{
    protected $table = 'posts';

    protected $primaryKey = 'post_id';
}
