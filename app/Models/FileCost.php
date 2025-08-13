<?php

namespace App\Models;

use App\Enums\Payment\PaymentStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class FileCost extends Model
{
    use HasFactory;

    protected $table = 'file_costs';

    protected $primaryKey = 'id';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'file_id',
        'customer_id',
        'supplier_id',
        'file_item_id',
        'service_type',
        'description',
        'quantity',
        'unit_price',
        'total_price',
        'original_currency',
        'exchange_rate',
        'base_currency',
        'converted_total',
        'payment_status',
        'amount_paid',
        'payment_date',
        'number_of_people',
        'quantity_anomaly',
        'service_date',
        'notes',
        'created_by',
    ];

    protected $casts = [
        'quantity' => 'integer',
        'unit_price' => 'decimal:2',
        'total_price' => 'decimal:2',
        'exchange_rate' => 'decimal:6',
        'converted_total' => 'decimal:2',
        'amount_paid' => 'decimal:2',
        'quantity_anomaly' => 'boolean',
        'service_date' => 'date',
        'payment_date' => 'date',
        'payment_status' => PaymentStatus::class,
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = (string) Str::uuid();
            }
            // Calculate totals if not set
            if (empty($model->total_price)) {
                $model->total_price = $model->quantity * $model->unit_price;
            }
            if (empty($model->converted_total)) {
                $model->converted_total = $model->total_price * $model->exchange_rate;
            }
        });

        static::updating(function ($model) {
            // Recalculate totals if relevant fields change
            if ($model->isDirty(['quantity', 'unit_price', 'exchange_rate'])) {
                $model->total_price = $model->quantity * $model->unit_price;
                $model->converted_total = $model->total_price * $model->exchange_rate;
            }
        });
    }

    public function file(): BelongsTo
    {
        return $this->belongsTo(File::class);
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class);
    }

    public function fileItem(): BelongsTo
    {
        return $this->belongsTo(FileItem::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Helper method to get payment status label
    public function getPaymentStatusLabelAttribute(): string
    {
        return PaymentStatus::from($this->payment_status)->label();
    }

    // Scope for payment status
    public function scopePaymentStatus($query, $status)
    {
        return $query->where('payment_status', $status);
    }
}
