<?php

namespace App\Livewire;

use App\Models\File;
use App\Models\FileItem;
use Livewire\Component;

class ItemsTable extends Component
{
    public $file;
    public $editingId = null;
    public $editItem = [];
    public $selectedItemId;

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
        $this->editItem = $item->only([
            'service_name', 'description', 'quantity', 
            'unit_price', 'currency_id'
        ]);
    }

    public function cancel()
    {
        $this->editingId = null;
        $this->reset('editItem');
    }

    public function save()
    {
        $this->validate();
        FileItem::find($this->editingId)->update($this->editItem);
        $this->file->refresh();
        $this->cancel();
    }

    public function selectItemForCost($itemId)
    {
        $this->selectedItemId = $itemId;
        $this->dispatch('openAddCostModal');
    }

    public function render()
    {
        return view('livewire.file-items-table', [
            'items' => $this->file->items()
                ->with(['currency', 'costs.supplier'])
                ->withSum('costs', 'total_price')
                ->get(),
            'currencies' => \App\Models\Currency::all(),
            'suppliers' => \App\Models\Supplier::all(),
        ]);
    }
}