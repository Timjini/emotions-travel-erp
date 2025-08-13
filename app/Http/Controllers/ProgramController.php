<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProgramRequest;
use App\Models\Currency;
use App\Models\Program;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class ProgramController extends Controller
{
    public function index()
    {
        $programs = Program::orderBy('created_at', 'desc')->paginate(10);

        return view('programs.index', compact('programs'));
    }

    public function create()
    {
        $currencies = Currency::where('is_active', true)
            ->orderBy('name')
            ->get();
        $program = new Program();

        return view('programs.create', compact('currencies', 'program'));
    }

    public function store(StoreProgramRequest $request)
    {
        Program::create($request->validated() + [
            'company_id' => Auth::user()->company_id,
            'created_by' => Auth::id(),
        ]);

        return redirect()->route('programs.index')
            ->with('success', 'Program created successfully.');
    }


    public function show(Program $program)
    {
        return view('programs.show', compact('program'));
    }

    public function edit(Program $program)
    {
        $currencies = Currency::where('is_active', true)
            ->orderBy('name')
            ->get();

        return view('programs.edit', compact('program', 'currencies'));
    }

    public function update(StoreProgramRequest $request, Program $program)
    {

        $validated = $request->validated();

        $program->update($validated);

        return redirect()->route('programs.index')->with('success', 'Program updated successfully.');
    }

    public function destroy(Program $program): RedirectResponse
    {
        $program->delete();

        return redirect()->route('programs.index')
            ->with('success', 'Program deleted successfully.');
    }
}
