<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'company_id',
        'project_name',
        'project_volume',
        'project_file',
        'project_type_id',
        'talent',
        'qc_agent',
        'project_rate',
        'qc_rate',
        'bonuses',
        'status',
        'start_date',
        'finish_date'
    ];

    protected $casts = [
        'start_date' => 'date',
        'finish_date' => 'date',
        'project_rate' => 'decimal:2',
        'qc_rate' => 'decimal:2',
        'bonuses' => 'decimal:2'
    ];

    // Relationship with User (creator)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relationship with Company
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    // Relationship with ProjectType
    public function projectType()
    {
        return $this->belongsTo(ProjectType::class);
    }

    // Relationship with assigned Talent (User)
    public function assignedTalent()
    {
        return $this->belongsTo(User::class, 'talent');
    }

    // Relationship with QC Agent (User)
    public function assignedQcAgent()
    {
        return $this->belongsTo(User::class, 'qc_agent');
    }

    public function projectLogs()
    {
        return $this->hasMany(ProjectLog::class);
    }

    /**
     * Get the user assigned as the QC agent for the project.
     */
    public function qcAgent()
    {
        return $this->belongsTo(\App\Models\User::class, 'qc_agent');
    }
}
