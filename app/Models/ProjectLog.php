<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'project_id',
        'company_id',
        'talent_id',
        'talent_qc_id',
        'timestamp',
        'status'
    ];

    protected $casts = [
        'timestamp' => 'datetime'
    ];

    // Relationship with User (who created the log)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relationship with Project
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    // Relationship with Company
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    // Relationship with Talent (User)
    public function talent()
    {
        return $this->belongsTo(User::class, 'talent_id');
    }

    // Relationship with Talent QC (User)
    public function talentQc()
    {
        return $this->belongsTo(User::class, 'talent_qc_id');
    }
}
