<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;


class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'company_name',
        'company_type',
        'country',
        'contact_person_name',
    ];

    /**
     * Generate slug from company name
     */
    public function getSlugAttribute()
    {
        return Str::slug($this->company_name);
    }

    /**
     * Get the user that owns the company.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function talent()
    {
        return $this->hasMany(Talent::class);
    }

    public function project()
    {
        return $this->hasMany(Project::class);
    }

    public function projectType()
    {
        return $this->hasMany(ProjectType::class);
    }

    public function projectLogs()
    {
        return $this->hasMany(ProjectLog::class);
    }

    public function projectsSop()
    {
        return $this->hasMany(ProjectSop::class);
    }

    public function companyTalent()
    {
        return $this->hasMany(CompanyTalent::class);
    }


}
