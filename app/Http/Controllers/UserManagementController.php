<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::where('id', '!=', Auth::user()->id)
            ->where('role', '!=', 'superadmin')
            ->orderBy('name', 'desc')
            ->get();

        return view('usersmanagement.index', compact('users'));
    }

    public function promote(string $id)
    {
        $user = User::findOrFail($id);

        $user->update([
            'role' => 'admin',
        ]);

        session()->flash('success', $user->name .' berhasil dipromosikan menjadi admin');

        return redirect()->route('management.users.index');
    }

    public function demote(string $id)
    {
        $user = User::findOrFail($id);

        // Check if it superadmin
        if ($user->role === 'superadmin') {
            session()->flash('fail', 'Superadmin tidak bisa dikurangi menjadi user');
            return redirect()->route('management.users.index');
        }

        $user->update([
            'role' => 'user',
        ]);

        session()->flash('success', $user->name . ' berhasil dikurangi menjadi user');

        return redirect()->route('management.users.index');
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
