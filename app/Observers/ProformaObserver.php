<?php

namespace App\Observers;

use App\Models\Proforma;

class ProformaObserver
{
    /**
     * Handle the Proforma "created" event.
     */
    public function created(Proforma $proforma): void
    {
        //
    }

    /**
     * Handle the Proforma "updated" event.
     */
    public function updated(Proforma $proforma): void
    {
        //
    }

    /**
     * Handle the Proforma "deleted" event.
     */
    public function deleted(Proforma $proforma): void
    {
        //
    }

    /**
     * Handle the Proforma "restored" event.
     */
    public function restored(Proforma $proforma): void
    {
        //
    }

    /**
     * Handle the Proforma "force deleted" event.
     */
    public function forceDeleted(Proforma $proforma): void
    {
        //
    }
}
