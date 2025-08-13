<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class InvoiceItem extends Model
{
    use HasUuids;

    protected $table = 'invoice_items';

    protected $primaryKey = 'id';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'invoice_id',
        'service_name',
        'description',
        'quantity',
        'unit_price',
        'total_price',
        'currency_id',
    ];

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }
}
