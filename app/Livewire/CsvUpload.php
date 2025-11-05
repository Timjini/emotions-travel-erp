<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Services\Csv\CsvImporter;
use App\Models\Country;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class CsvUpload extends Component
{
    use WithFileUploads;

    /** @var \Livewire\TemporaryUploadedFile|null */
    public $csvFile;

    public string $model = '';
    public ?array $mappings = [];
    public string $label = 'Upload CSV';

    protected CsvImporter $csvImporter;

    /**
     * Boot method: inject CsvImporter
     */
    public function boot(CsvImporter $csvImporter)
    {
        $this->csvImporter = $csvImporter;
    }

    /**
     * Handle CSV import
     */
    public function importCsv()
    {

        dd('importCsv method called!');
        // dd('here');       
        // Log::info('CSV imprt started....');
        // $this->validate([
        //     'csvFile' => 'required|file|mimes:csv,txt|max:2048',
        //     'model'   => 'required|string',
        // ]);

        // try {
        //     Log::info('Starting CSV import', [
        //         'original_name' => $this->csvFile->getClientOriginalName(),
        //         'model' => $this->model,
        //     ]);

        //     // // Store temporarily
        //     $path = $this->csvFile->store('uploads', 'private');
        //     Log::info('CSV stored', ['path' => $path]);
        //     Log::channel('livewire')->info('CSV stored', ['path' => $path]);


        //     // Import using service
        //     $imported = $this->csvImporter->import(
        //         $path,
        //         $this->model,
        //         $this->mappings ?? []
        //     );

        //     // Notify frontend
        //     $this->dispatch('csvImported', [
        //         'count' => count($imported),
        //         'model' => class_basename($this->model),
        //     ]);

        //     session()->flash('message', "Successfully imported " . count($imported) . " records!");
        // } catch (\Throwable $e) {
        //     Log::error('CSV import failed', [
        //         'error' => $e->getMessage(),
        //         'trace' => $e->getTraceAsString(),
        //         'file' => $e->getFile(),
        //         'line' => $e->getLine(),
        //     ]);

        //     session()->flash('error', 'Import failed: ' . $e->getMessage());
        // } finally {
        //     // Clean up uploaded file
        //     if (isset($path)) {
        //         Storage::disk('private')->delete($path);
        //     }
        // }
    }

    /**
     * Render component view
     */
    public function render()
    {
        return view('livewire.csv-upload');
    }
}
