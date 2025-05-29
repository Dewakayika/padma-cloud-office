<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyTalent extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'user_id',
        'talent_id',
        'job_role'
    ];

    // Relationship with Company
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    // Relationship with User (who created the assignment)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relationship with Talent (User)
    public function talent()
    {
        return $this->belongsTo(User::class, 'talent_id');
    }
}
