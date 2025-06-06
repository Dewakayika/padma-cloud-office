<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;

    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',

    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function company()
    {
        return $this->hasMany(Company::class);
    }

    public function talent()
    {
        return $this->hasOne(Talent::class);
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
        return $this->hasMany(CompanyTalent::class, 'talent_id');
    }

    /**
     * Get the project records where the user is the company user.
     */
    public function companyProjectRecords()
    {
        return $this->hasMany(ProjectRecord::class, 'user_id');
    }

    /**
     * Get the project records where the user is the talent.
     */
    public function talentProjectRecords()
    {
        return $this->hasMany(ProjectRecord::class, 'talent_id');
    }

    /**
     * Get the project records where the user is the QC.
     */
    public function qcProjectRecords()
    {
        return $this->hasMany(ProjectRecord::class, 'qc_id');
    }
}
