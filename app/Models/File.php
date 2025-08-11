<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class File extends Model
{
    use HasFactory, SoftDeletes;

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
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date'   => 'date',
    ];


        protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = (string) Str::uuid();
            }
        });
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

}