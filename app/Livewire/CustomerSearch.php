<?php

namespace App\Livewire;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;

class CustomerSearch extends Component
{
    public $search = '';

    public $highlightIndex = 0;

    public $selectedCustomer = null;

    public $showDropdown = false;

    protected $listeners = ['resetCustomerSelection' => 'resetSelection'];

    public function render()
    {
        $customers = collect([]);

        if (strlen($this->search) >= 2) {
            $customers = Customer::query()
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

        return view('livewire.customer-search', [
            'customers' => $customers,
        ]);
    }

    public function selectCustomer($customerId)
    {
        $this->selectedCustomer = Customer::find($customerId);
        $this->search = $this->selectedCustomer->name;
        $this->showDropdown = false;
        $this->reset('highlightIndex');

        $this->dispatch('customerSelected', customerId: $customerId);
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
        $this->reset(['search', 'highlightIndex', 'selectedCustomer', 'showDropdown']);
    }

    public function incrementHighlight()
    {
        if ($this->highlightIndex === count($this->customers) - 1) {
            $this->highlightIndex = 0;
        } else {
            $this->highlightIndex++;
        }
    }

    public function decrementHighlight()
    {
        if ($this->highlightIndex === 0) {
            $this->highlightIndex = count($this->customers) - 1;
        } else {
            $this->highlightIndex--;
        }
    }

    public function resetSearch()
    {
        $this->reset(['search', 'highlightIndex']);
    }
}
