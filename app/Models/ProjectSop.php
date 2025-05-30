<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectSop extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'company_id',
        'project_type_id',
        'sop_formula',
        'description'
    ];

    // Relationship with User (who created the SOP)
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
}
