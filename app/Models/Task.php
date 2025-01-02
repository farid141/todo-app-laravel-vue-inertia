<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $guarded = ['id'];

    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'task_user');
    }

    public function subtasks()
    {
        return $this->hasMany(Subtask::class);
    }
}
