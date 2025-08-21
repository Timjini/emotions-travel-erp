<?php
namespace App\Events;

use App\Models\Proforma;
use App\Models\User;
use Illuminate\Foundation\Events\Dispatchable;

class ProformaSendFailed
{
    use Dispatchable;

    public function __construct(
        public Proforma $proforma,
        public User $sender,
        public string $errorMessage
    ) {}
}