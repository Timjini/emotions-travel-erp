<?php

namespace App\Models;

use App\Traits\BelongsToCompany;
use App\Traits\CreatedByTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Destination extends Model
{
    use HasFactory, BelongsToCompany, CreatedByTrait;

    protected $table = 'destinations';
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
        'country',
        'city',
        'region',
        'latitude',
        'longitude',
        'timezone',
        'airport_code',
        'currency_id',
        'visa_required',
        'best_season',
        'average_temperature',
        'description',
        'is_active',
    ];

    protected $casts = [
        'is_active'     => 'boolean',
        'visa_required' => 'boolean',
        'latitude'      => 'float',
        'longitude'     => 'float',
    ];

    /**
     * Get all files for this destination
     */
    public function files(): HasMany
    {
        return $this->hasMany(File::class);
    }

       public function programs()
    {
        return $this->hasMany(Program::class);
    }

     public function currency()
    {
        return $this->belongsTo(Currency::class);
    }
}
