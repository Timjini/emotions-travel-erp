<?php

namespace App\Livewire;

use App\Models\Supplier;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;

class SupplierSearch extends Component
{
    public $search = '';

    public $highlightIndex = 0;

    public $selectedSupplier = null;

    public $showDropdown = false;

    protected $listeners = ['resetSupplierSelection' => 'resetSelection'];

    public function render()
    {
        $suppliers = collect([]);

        if (strlen($this->search) >= 2) {
            $suppliers = Supplier::query()
                ->where(function (Builder $query) {
                    $query->where('name', 'like', '%'.$this->search.'%')
                        ->orWhere('email', 'like', '%'.$this->search.'%')
                        ->orWhere('contact_person', 'like', '%'.$this->search.'%')
                        ->orWhere('phone_1', 'like', '%'.$this->search.'%')
                        ->orWhere('phone_2', 'like', '%'.$this->search.'%')
                        ->orWhere('invoicing_entity', 'like', '%'.$this->search.'%')
                        ->orWhere('vat_number', 'like', '%'.$this->search.'%');
                })
                ->orderBy('name')
                ->limit(10)
                ->get();
        }

        return view('livewire.supplier-search', [
            'suppliers' => $suppliers,
        ]);
    }

    public function selectSupplier($supplierId)
    {
        $this->selectedSupplier = Supplier::find($supplierId);
        $this->search = $this->selectedSupplier->name;
        $this->showDropdown = false;
        $this->reset('highlightIndex');

        $this->dispatch('supplierSelected', supplierId: $supplierId);
    }

    public function updatedSearch()
    {
        $this->showDropdown = true;
    }

    public function closeDropdown()
    {
        usleep(150000);
        $this->showDropdown = false;
    }

    public function resetSelection()
    {
        $this->reset(['search', 'highlightIndex', 'selectedSupplier', 'showDropdown']);
    }

    public function incrementHighlight()
    {
        if ($this->highlightIndex === count($this->suppliers) - 1) {
            $this->highlightIndex = 0;
        } else {
            $this->highlightIndex++;
        }
    }

    public function decrementHighlight()
    {
        if ($this->highlightIndex === 0) {
            $this->highlightIndex = count($this->suppliers) - 1;
        } else {
            $this->highlightIndex--;
        }
    }

    public function resetSearch()
    {
        $this->reset(['search', 'highlightIndex']);
    }
}
