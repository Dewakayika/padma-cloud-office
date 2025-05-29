<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Talent extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'phone_number',
        'address',
        'gender',
        'date_of_birth',
        'id_card',
        'bank_name',
        'bank_account',
        'swift_code',
        'subjected_tax',
    ];

    /**
     * Get the user that owns the talent profile.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}