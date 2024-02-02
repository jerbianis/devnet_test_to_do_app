<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description'
    ];

    public function tasks()
    {
        return $this->hasMany(ProjectTask::class);
    }

    public function countToDoTasks()
    {
        return $this->tasks()->where('status', 'todo')->count();
    }
    public function countDoingTasks()
    {
        return $this->tasks()->where('status', 'doing')->count();
    }
    public function countDoneTasks()
    {
        return $this->tasks()->where('status', 'done')->count();
    }
}
