<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Storage;

class Post extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title','description','content', 'image','published_at', 'category_id'
];

/**
 *
 * Delete post images from storage
 * @return void
 */
public function deleteImage(){
    Storage::delete($this->image);
}

/**
 *
 * Relationship between post and category
 */
public function category(){
    return $this->belongsTo(Category::class);
}

}
