<?php

namespace App\Livewire;

use App\Models\File;
use App\Models\FileItem;
use Livewire\Component;
use Illuminate\Support\Facades\Log;


class ItemsTable extends Component
{
    public $file;
    public $editingId = null;
    public $editItem = [
        'service_name' => '',
        'description' => '',
        'quantity' => 0,
        'unit_price' => 0,
        'currency_id' => null
    ];

    protected $rules = [
        'editItem.service_name' => 'required|string|max:255',
        'editItem.description' => 'nullable|string',
        'editItem.quantity' => 'required|numeric|min:1',
        'editItem.unit_price' => 'required|numeric|min:0',
        'editItem.currency_id' => 'required|exists:currencies,id'
    ];

    public function mount(File $file)
    {
        $this->file = $file;
    }

    public function edit($itemId)
    {
        $this->editingId = $itemId;
        $item = FileItem::find($itemId);
        $this->editItem = [
            'service_name' => $item->service_name,
            'description' => $item->description,
            'quantity' => $item->quantity,
            'unit_price' => $item->unit_price,
            'currency_id' => $item->currency_id
        ];
    }

    public function cancel()
    {
        $this->editingId = null;
        $this->reset('editItem');
    }

    public function update()
    {
        $this->validate();
        
        $item = FileItem::find($this->editingId);
        $item->update($this->editItem);
        
        $this->file->refresh();
        $this->cancel();
    }

    public function save()
    {
    // Validation first — keep it explicit
    $this->validate();

    // Log incoming state for Telescope inspection
    Log::info('Updating FileItem', [
        'editingId' => $this->editingId,
        'editItem' => $this->editItem,
        'timestamp' => now()->toDateTimeString(),
    ]);

    // Fetch the model and check existence
    $item = FileItem::findOrFail($this->editingId);

    // Log current DB state before update
    Log::info('Current FileItem before update', $item->toArray());

    // Perform the update
    $item->update($this->editItem);

    // Log after update
    Log::info('FileItem after update', $item->fresh()->toArray());

    // Refresh the related file object
    $this->file->refresh();

    // Reset form state
    $this->cancel();

    // Dispatch event to browser
    // $this->dispatchBrowserEvent('item-updated', [
    //     'message' => 'Item updated successfully!'
    // ]);
}

    public function render()
    {
        return view('livewire.file-items-table', [
            'items' => $this->file->items()->with('currency')->get(),
            'currencies' => \App\Models\Currency::all()
        ]);
    }
}
