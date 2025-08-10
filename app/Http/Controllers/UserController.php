<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash; 


class UserController extends Controller
{
    /**
     * Display a listing of all users.
     */
    public function index(): View
    {
        return view('users.index', [
            'users' => User::query()
                ->latest()
                ->paginate(10)
        ]);
    }
    
    
    public function show($id): View
    {
        $user = User::with('settings')->findOrFail($id);
        
        // $this->authorize('view', $user);
        
        return view('users.show', [
            'user' => $user,
            'userSettings' => $user->settings
        ]);
    }
    
    public function create()
    {
        return view('users.create');
    }
    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|confirmed|min:8',
            // 'role' => 'sometimes|in:user,editor,admin'
        ]);
    
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);
    
        // Assign role if using role management
        if (isset($validated['role'])) {
            $user->assignRole($validated['role']);
        }
    
        return redirect()->route('users.index')
            ->with('success', 'User created successfully');
    }
    
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        
        // Hash the email before soft deleting
        $user->email = Hash::make($user->email . now()->timestamp);
        $user->save();
        
        // Soft delete the user
        $user->delete();
        
        return redirect()->route('users.index')
            ->with('success', 'User deactivated successfully');
    }
}