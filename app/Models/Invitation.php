<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Invitation extends Model
{
    use HasFactory;

    protected $fillable = [
        'email',
        'token',
        'company_id',
        'inviting_user_id',
        'expires_at',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
    ];

    // Relationship with Company
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    // Relationship with User (who sent the invitation)
    public function invitingUser()
    {
        return $this->belongsTo(User::class, 'inviting_user_id');
    }
}
