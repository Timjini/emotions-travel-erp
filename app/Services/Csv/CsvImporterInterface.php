<?php

namespace App\Services\Csv;

interface CsvImporterInterface
{
    /**
     * Import array data into the model
     *
     * @param string $modelClass
     * @param array $dataArray Array of associative arrays representing each row
     * @return array Imported models
     */
    public function import(string $modelClass, array $dataArray): array;
}
