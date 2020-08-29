<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    // Attribute multiple books to a single category
    public function books(){
        return $this->hasMany('App\Book');
    }
}
