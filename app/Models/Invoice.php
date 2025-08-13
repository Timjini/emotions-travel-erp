<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasUuids;

    const STATUS_UNPAID = 'unpaid';

    const STATUS_PAID = 'paid';

    const STATUS_CANCELLED = 'cancelled';

    const STATUS_REFUNDED = 'refunded';

    protected $table = 'invoices';

    protected $primaryKey = 'id';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'file_id',
        'proforma_id',
        'invoice_number',
        'issue_date',
        'due_date',
        'total_amount',
        'currency_id',
        'status',
        'notes',
    ];

    protected $casts = [
        'due_date' => 'date',
        'issue_date' => 'date',
    ];

    public function file()
    {
        return $this->belongsTo(File::class);
    }

    public function proforma()
    {
        return $this->belongsTo(Proforma::class);
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }

    public function items()
    {
        return $this->hasMany(InvoiceItem::class);
    }
}
