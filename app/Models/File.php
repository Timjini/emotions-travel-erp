<?php

namespace App\Models;

use App\Traits\BelongsToCompany;
use App\Traits\CreatedByTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;


class File extends Model
{
    use HasFactory, SoftDeletes, BelongsToCompany, CreatedByTrait;

    public const STATUS_PENDING = 'pending';

    public const STATUS_CONFIRMED = 'confirmed';

    public const STATUS_CANCELLED = 'cancelled';

    protected $table = 'files';

    protected $primaryKey = 'id';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'customer_id',
        'reference',
        'number_of_people',
        'start_date',
        'end_date',
        'program_id',
        'destination_id',
        'currency_id',
        'guide',
        'note',
        'status',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

      protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {

            if (empty($model->id)) {
                $model->id = (string) Str::uuid();
            }

            if (empty($model->reference)) {
                $model->reference = 'REF-' . now()->format('Ymd') . '-' . random_int(1000, 9999);
            }
        });
    }

    public static function getStatuses(): array
    {
        return [
            self::STATUS_PENDING,
            self::STATUS_CONFIRMED,
            self::STATUS_CANCELLED,
        ];
    }

    // Relations
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function program()
    {
        return $this->belongsTo(Program::class);
    }

    public function destination()
    {
        return $this->belongsTo(Destination::class);
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(FileItem::class);
    }

    /**
     * Get all costs associated with this file
     */
    public function costs(): HasMany
    {
        return $this->hasMany(FileCost::class);
    }

    public function proformas()
    {
        return $this->hasMany(Proforma::class);
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
