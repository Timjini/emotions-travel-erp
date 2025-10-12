<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Setting extends Model
{
    protected $table = 'settings';

    protected $primaryKey = 'id';

    public $incrementing = false;

    protected $keyType = 'string';

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = (string) Str::uuid();
            }
        });
    }

    protected $fillable = [
        'company_id',
        'iban', 'swift_code', 'bank_name', 'bank_account_name',
        'preferred_language', 'timezone', 'date_format', 'financial_year_start',
        'invoice_prefix', 'invoice_start_number', 'invoice_due_days', 'invoice_currency',
        'contact_person', 'phone_2', 'website', 'district',
        'notes', 'source',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }
}
