<?php

namespace App\Models;

use App\Enums\CustomerCategory;
use App\Enums\CustomerStatus;
use App\Enums\CustomerType;
use App\Traits\BelongsToCompany;
use App\Traits\CreatedByTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Customer extends Model
{
    use HasFactory, SoftDeletes, BelongsToCompany, CreatedByTrait;

    protected $table = 'customers';

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
        'name',
        'invoicing_entity',
        'email',
        'contact_person',
        'website',
        'address',
        'post_code',
        'city',
        'district',
        'country',
        'phone_1',
        'phone_2',
        'vat_number',
        'type',
        'category',
        'iban',
        'swift_code',
        'status',
        'preferred_language',
        'notes',
        'source',
        'created_by',
    ];

    protected $casts = [
        'type' => CustomerType::class,
        'category' => CustomerCategory::class,
        'status' => CustomerStatus::class,
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    public function scopeSuppliers($query)
    {
        return $query->whereNotIn('type', ['client', 'customer']);
    }
    // relations

    public function files()
    {
        return $this->hasMany(File::class);
    }

    public function suppliers()
    {
        return $this->hasMany(Customer::class)->where('type', 'supplier');
    }
}
