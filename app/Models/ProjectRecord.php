<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProjectRecord extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'company_id',
        'project_id',
        'talent_id',
        'qc_id',
        'status',
        'qc_message',
        'project_link',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the company user that owns the project record.
     */
    public function companyUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the company that owns the project record.
     */
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    /**
     * Get the project that owns the project record.
     */
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * Get the talent user that owns the project record.
     */
    public function talent(): BelongsTo
    {
        return $this->belongsTo(User::class, 'talent_id');
    }

    /**
     * Get the QC user that owns the project record.
     */
    public function qc(): BelongsTo
    {
        return $this->belongsTo(User::class, 'qc_id');
    }

    /**
     * Scope a query to only include records for a specific talent.
     */
    public function scopeForTalent($query, $talentId)
    {
        return $query->where('talent_id', $talentId);
    }

    /**
     * Scope a query to only include records for a specific QC.
     */
    public function scopeForQC($query, $qcId)
    {
        return $query->where('qc_id', $qcId);
    }

    /**
     * Scope a query to only include records for a specific company.
     */
    public function scopeForCompany($query, $companyId)
    {
        return $query->where('company_id', $companyId);
    }

    /**
     * Scope a query to only include records with a specific status.
     */
    public function scopeWithStatus($query, $status)
    {
        return $query->where('status', $status);
    }
}
