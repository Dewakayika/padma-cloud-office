<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectType extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_name',
        'user_id',
        'company_id',
        'project_rate'
    ];

    // Relationship with Projects
    public function projects()
    {
        return $this->hasMany(Project::class);
    }

    public function projectsSop()
    {
        return $this->hasMany(ProjectSop::class);
    }

}
