<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    // Attribute a book to just one user
    public function user(){
        return $this->belongsTo('App\User');
    }
    // Attribute a book to only one category
    public function category(){
        return $this->belongsTo('App\Category');
    }
}
