<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;


class FileItem extends Model
{
    use HasFactory;

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'file_id',
        'service_name',
        'description',
        'quantity',
        'unit_price',
        'total_price',
        'currency_id',
    ];

    protected $casts = [
        'unit_price' => 'decimal:2',
        'total_price' => 'decimal:2',
        'quantity' => 'integer',
    ];

    protected static function booted()
    {
        static::creating(function ($model) {
            $model->id = Str::uuid()->toString();
            // Calculate total price
            $model->total_price = $model->unit_price * $model->quantity * $model->file->number_of_people;
        });

        static::updating(function ($model) {
            $model->total_price = $model->unit_price * $model->quantity * $model->file->number_of_people;
        });
    }

    /**
     * Get the file that owns this item
     */
    public function file(): BelongsTo
    {
        return $this->belongsTo(File::class);
    }

    /**
     * Get the currency for this item
     */
    public function currency(): BelongsTo
    {
        return $this->belongsTo(Currency::class);
    }

    /**
     * Calculate total price before saving
     */
    // protected static function booted()
    // {
    //     static::saving(function ($item) {
    //         $item->total_price = $item->unit_price * $item->quantity * $item->file->number_of_people;
    //     });
    // }

    public function supplier()
    {
        return $this->belongsTo(Customer::class, 'supplier_id');
    }
}