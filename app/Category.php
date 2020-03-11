<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name'];

    /**
     *
     * Relationship between Posts and Category
     */
     public function posts(){
         return $this->hasMany(Post::class);
     }
}

