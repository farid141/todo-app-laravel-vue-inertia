<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $guarded=['id'];

    public function tags() {
        return $this->morphToMany(Tag::class, 'taggable');
    }

    public function user() {
        return $this->belongsToMany(User::class, 'task_user');
    }
}
