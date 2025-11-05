<?php

namespace App\Services\Csv;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CsvImporter implements CsvImporterInterface
{
    /**
     * Import array data into the model
     *
     * @param string $modelClass
     * @param array $dataArray Array of associative arrays representing each row
     * @return array Imported models
     */
    public function import(string $modelClass, array $dataArray): array
    {

        if (!class_exists($modelClass)) {
            throw new \InvalidArgumentException("Model class {$modelClass} does not exist.");
        }

        $imported = [];

        foreach ($dataArray as $data) {
            $model = new $modelClass();
            $model->fill($data);

            // Optional: set created_by if available
            if (Auth::check() && in_array('created_by', $model->getFillable())) {
                $model->created_by = Auth::id();
            }

            $model->save();
            $imported[] = $model;
        }

        return $imported;
    }
}
