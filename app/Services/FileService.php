<?php

namespace App\Services;

use App\Models\File;
use Illuminate\Support\Facades\DB;

class FileService
{
    public function createFileWithItems(array $data, array $items)
    {
        return DB::transaction(function () use ($data, $items) {
            $file = File::create($data);

            foreach ($items as $item) {
                $file->items()->create($item);
            }

            return $file;
        });
    }
}
