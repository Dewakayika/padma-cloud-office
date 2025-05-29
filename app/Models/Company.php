<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


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
     * Get the user that owns the company.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function talent(): HasMany
    {
        return $this->hasMany(Talent::class);
    }

    public function project(): HasMany
    {
        return $this->hasMany(Project::class);
    }

    public function projectType(): HasMany
    {
        return $this->hasMany(ProjectType::class);
    }

    public function projectLogs(): HasMany
    {
        return $this->hasMany(ProjectLog::class);
    }

    public function projectsSop(): HasMany
    {
        return $this->hasMany(ProjectSop::class);
    }

    public function companyTalent(): HasMany
    {
        return $this->hasMany(CompanyTalent::class);
    }


}
