<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Register;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    // show profile
   public function show(Request $request)
{
    $userId = $request->session()->get('user_id');

    if (!$userId) {
        return redirect('/helo')->with('error', 'Please login first.');
    }

    $user = \App\Models\Register::find($userId); 
    return view('profile', compact('user'));
}



    // edit profile
    public function edit(Request $request)
{
    $userId = $request->session()->get('user_id'); 

    if (!$userId) {
        return redirect('/helo')->with('error', 'Please login first.');
    }

    $user = \App\Models\Register::find($userId); 

    return view('profile_edit', compact('user'));
}


    // update profile
    public function update(Request $request)
{
    $userId = $request->session()->get('user_id');
    if (!$userId) {
        return redirect('/helo')->with('error', 'Please login first.');
    }

    $user = Register::find($userId);

    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255|unique:registers,email,' . $user->id,
        'password' => 'nullable|string|min:8|max:20',
        'contact' => 'required',
        'address' => 'required|string',
    ]);

    $user->name = $request->name;
    $user->email = $request->email;
    $user->contact = $request->contact;
    $user->address = $request->address;

    if ($request->password) {
        $user->password = Hash::make($request->password);
    }

    $user->save();

    return redirect()->route('profile.show')->with('success', 'Profile updated successfully!');
}


    // delete account
    public function destroy(Request $request)
    {
        $sessionUser = $request->session()->get('user');

        if (!$sessionUser) {
            return redirect('/helo')->with('error', 'Please login first.');
        }

        $user = Register::find($sessionUser->id);
        $user->delete();

        $request->session()->forget('user');
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Account deleted successfully!');
    }
}
