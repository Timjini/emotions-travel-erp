<?php

namespace App\Livewire;

use App\Models\Destination;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;

class DestinationSearch extends Component
{
    public $search = '';
    public $highlightIndex = 0;
    public $selectedDestination = null;
    public $showDropdown = false;

    protected $listeners = ['resetDestinationSelection' => 'resetSelection'];

    public function render()
    {
        $destinations = collect([]);

        if (strlen($this->search) >= 2) {
            $destinations = Destination::query()
                ->with('country') 
                ->where(function (Builder $query) {
                    $query->where('name', 'like', '%' . $this->search . '%')
                        ->orWhereHas('country', function (Builder $countryQuery) {
                            $countryQuery->where('name', 'like', '%' . $this->search . '%');
                        });
                })
                ->orderBy('name')
                ->limit(10)
                ->get();
        }

        return view('livewire.destination-search', [
            'destinations' => $destinations,
        ]);
    }

    public function selectDestination($destinationId)
    {
        $this->selectedDestination = Destination::find($destinationId);
        $this->search = $this->selectedDestination->name;
        $this->showDropdown = false;
        $this->reset('highlightIndex');

        $this->dispatch('destinationSelected', destinationId: $destinationId);
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
        $this->reset(['search', 'highlightIndex', 'selectedDestination', 'showDropdown']);
    }

    public function incrementHighlight()
    {
        if ($this->highlightIndex === count($this->destinations) - 1) {
            $this->highlightIndex = 0;
        } else {
            $this->highlightIndex++;
        }
    }

    public function decrementHighlight()
    {
        if ($this->highlightIndex === 0) {
            $this->highlightIndex = count($this->destinations) - 1;
        } else {
            $this->highlightIndex--;
        }
    }

    public function resetSearch()
    {
        $this->reset(['search', 'highlightIndex']);
    }
}
