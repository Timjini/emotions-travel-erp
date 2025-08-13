<?php

namespace App\Models;

use App\Traits\BelongsToCompany;
use App\Traits\CreatedByTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Currency extends Model
{
    use HasFactory, BelongsToCompany, CreatedByTrait;

    protected $table = 'currencies';

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
        'code',
        'symbol',
        'exchange_rate',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'exchange_rate' => 'float',
    ];

    /**
     * Get all files using this currency
     */
    public function files(): HasMany
    {
        return $this->hasMany(File::class);
    }

     public function programs()
    {
        return $this->hasMany(Program::class);
    }

    public function destinations()
    {
        return $this->hasMany(Destination::class);
    }
}
