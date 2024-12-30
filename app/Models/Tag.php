<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $guarded=['id'];

    public function tasks() {
        return $this->morphedByMany(Task::class, 'taggable');
    }

    public function subtasks() {
        return $this->morphedByMany(Subtask::class, 'taggable');
    }
}
