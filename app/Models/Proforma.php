<?php

namespace App\Models;

use App\Observers\ProformaObserver;
use App\Traits\BelongsToCompany;
use App\Traits\CreatedByTrait;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;


#[ObservedBy([ProformaObserver::class])]

class Proforma extends Model
{
    use HasUuids, BelongsToCompany, CreatedByTrait;

    protected $table = 'proformas';

    protected $primaryKey = 'id';

    public $incrementing = false;

    protected $keyType = 'string';

    const STATUS_DRAFT = 'draft';

    const STATUS_SENT = 'sent';

    const STATUS_ACCEPTED = 'accepted';

    const STATUS_CONVERTED = 'converted';

    const STATUS_CANCELLED = 'cancelled';

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
        'file_id',
        'proforma_number',
        'issue_date',
        'due_date',
        'total_amount',
        'currency_id',
        'notes',
        'status',
    ];

    protected $casts = [
        'due_date' => 'date',
        'issue_date' => 'date',
    ];

    public function file()
    {
        return $this->belongsTo(File::class);
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }

    public function invoice()
    {
        return $this->hasOne(Invoice::class);
    }
}
