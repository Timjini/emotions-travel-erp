<?php

namespace App\Models;

use App\Enums\Supplier\SupplierCategory;
use App\Enums\Supplier\SupplierStatus;
use App\Enums\Supplier\SupplierType;
use App\Traits\BelongsToCompany;
use App\Traits\CreatedByTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Supplier extends Model
{
    use HasFactory, SoftDeletes, BelongsToCompany, CreatedByTrait;

    protected $table = 'suppliers';

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
        'type' => SupplierType::class,
        'category' => SupplierCategory::class,
        'status' => SupplierStatus::class,
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    // relations

    public function files()
    {
        return $this->hasMany(File::class);
    }
}
