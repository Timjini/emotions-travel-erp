<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class FileUploadService
{
    public function uploadLogo(UploadedFile $file, string $directory = 'company-logos'): ?string
    {
        try {

            $filename = time().'_'.$file->getClientOriginalName();
            $path = $file->storeAs('logos', $filename, 'public');

            return $path;

        } catch (\Exception $e) {
            Log::error('Logo upload failed', [
                'error' => $e->getMessage(),
                'file' => $file->getClientOriginalName(),
                'trace' => $e->getTraceAsString(),
            ]);

            return null;
        }
    }

    public function deleteLogo(?string $path): bool
    {
        try {
            if ($path && Storage::disk('public')->exists($path)) {
                $result = Storage::disk('public')->delete($path);
                Log::error('Logo deleted', ['path' => $path, 'result' => $result]);

                return $result;
            }

            return false;
        } catch (\Exception $e) {
            Log::error('Logo deletion failed', [
                'error' => $e->getMessage(),
                'path' => $path,
            ]);

            return false;
        }
    }
}
