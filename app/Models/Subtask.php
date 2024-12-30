<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subtask extends Model
{
    protected $guarded=['id'];

    public function tags() {
        return $this->morphToMany(Tag::class, 'taggable');
    }
}
