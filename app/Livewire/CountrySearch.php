<?php

namespace App\Livewire;

use App\Models\Country;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;

class CountrySearch extends Component
{
    public $search = '';
    public $highlightIndex = 0;
    public $selectedCountry = null;
    public $showDropdown = false;

    protected $listeners = ['resetCountrySelection' => 'resetSelection'];

    public function render()
    {
        $countries = collect([]);

        if (strlen($this->search) >= 2) {
            $countries = Country::query()
                ->where(function (Builder $query) {
                    $query->where('name', 'like', '%'.$this->search.'%')
                        ->orWhere('code', 'like', '%'.$this->search.'%');
                })
                ->orderBy('name')
                ->limit(10)
                ->get();
        }

        return view('livewire.country-search', [
            'countries' => $countries,
        ]);
    }

    public function selectCountry($countryId)
    {
        $this->selectedCountry = Country::find($countryId);
        $this->search = $this->selectedCountry->name;
        $this->showDropdown = false;
        $this->reset('highlightIndex');

        $this->dispatch('countrySelected', 
            countryId: $countryId,
            countryName: $this->selectedCountry->name,
            countryCode: $this->selectedCountry->code
        );
    }

    public function updatedSearch()
    {
        $this->showDropdown = true;
        $this->selectedCountry = null;
    }

    public function closeDropdown()
    {
        usleep(150000);
        $this->showDropdown = false;
    }

    public function resetSelection()
    {
        $this->reset(['search', 'highlightIndex', 'selectedCountry', 'showDropdown']);
    }

    public function incrementHighlight()
    {
        if ($this->highlightIndex === count($this->countries) - 1) {
            $this->highlightIndex = 0;
        } else {
            $this->highlightIndex++;
        }
    }

    public function decrementHighlight()
    {
        if ($this->highlightIndex === 0) {
            $this->highlightIndex = count($this->countries) - 1;
        } else {
            $this->highlightIndex--;
        }
    }

    public function selectHighlighted()
    {
        if ($this->countries->isNotEmpty()) {
            $this->selectCountry($this->countries[$this->highlightIndex]->id);
        }
    }

    public function resetSearch()
    {
        $this->reset(['search', 'highlightIndex']);
    }
}