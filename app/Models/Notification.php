<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'discord_webhook_url',
        'discord_channel',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
