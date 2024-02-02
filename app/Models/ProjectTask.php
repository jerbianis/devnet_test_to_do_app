<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectTask extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'priority',
        'status',
        'estimation',
        'assigned_to',
        'is_valid'
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function assigned_to_user()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }
}
