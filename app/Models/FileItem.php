<?php

namespace App\Models;

use App\Traits\BelongsToCompany;
use App\Traits\CreatedByTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class FileItem extends Model
{
    use HasFactory, BelongsToCompany, CreatedByTrait;

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'file_id',
        'service_name',
        'external_ref',
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

    public function costs(): HasMany
    {
        return $this->hasMany(FileCost::class, 'file_item_id');
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

}
