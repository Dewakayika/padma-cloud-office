<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;
use App\Services\CurrencyConverter;


class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'company_name',
        'company_type',
        'country',
        'contact_person_name',
        'registration_number',
        'address',
        'business_license_path',
        'billing_address',
        'billing_email',
        'invoice_recipient',
        'zip_code',
        'tax_id',
        'payment_schedule',
        'currency',
        'primary_use_case',
        'nda_agreed',
        'collaboration_tools',
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

    /**
     * Get the project records for the company.
     */
    public function projectRecords()
    {
        return $this->hasMany(ProjectRecord::class);
    }

    public function notification()
    {
        return $this->hasOne(Notification::class);
    }

    /**
     * Static options for payment schedule and currency dropdowns
     */
    public static function paymentScheduleOptions()
    {
        return [
            'custom_date' => 'Custom Date',
        ];
    }

    public static function currencyOptions()
    {
        return [
            'USD' => 'USD - US Dollar',
            'JPY' => 'JPY - Japanese Yen',
            'IDR' => 'IDR - Indonesian Rupiah',
            'SGD' => 'SGD - Singapore Dollar',
            'AUD' => 'AUD - Australian Dollar',
            'EUR' => 'EUR - Euro',
        ];
    }

    public function convertCurrency($amount, $toCurrency)
    {
        return CurrencyConverter::convert($amount, $this->currency, $toCurrency);
    }

}
