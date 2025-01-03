<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function tasks()
    {
        return $this->belongsToMany(Task::class, 'task_user')->withPivot('role');
    }

    public function subtasks()
    {
        return $this->hasManyThrough(
            Subtask::class,
            Task::class,
            'id',           // Foreign key on 'task_user' table (tasks.id)
            'task_id',      // Foreign key on 'subtasks' table (subtasks.task_id)
            'id',           // Local key on 'users' table (users.id)
            'id'            // Local key on 'tasks' table
        )->join('task_user', 'tasks.id', '=', 'task_user.task_id')
            ->where('task_user.user_id', $this->id);
    }
}
