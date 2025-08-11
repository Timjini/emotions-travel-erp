<?php

namespace App\Http\Controllers;

use App\Models\Currency;
use App\Models\Customer;
use App\Models\Destination;
use App\Models\File;
use App\Models\FileItem;
use App\Models\Program;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;

class InvoiceController extends Controller
{
    /**
     * Display the files.
     */
    public function index(Request $request): View
    {
        // $files = File::with(['customer', 'program', 'destination', 'currency'])
        //     ->latest()
        //     ->paginate(10);
        $files = "new";

        return view('invoices.index', [
            'files' => $files,
        ]);
    }
}