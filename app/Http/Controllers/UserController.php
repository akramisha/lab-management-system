<?php

namespace App\Http\Controllers;
use App\Models\Register;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class UserController extends Controller
{
    // register show
    public function showRegistrationform()
    {
        return view('register');
    }
    // register process
    public function storeRegister(Request $request){
        $request->validate([
            'name'=>'required|string|max:255',
            'email'=>'required|email|unique:registers,email',
            'password'=>'required|min:8|max:20',
            'contact'=>'required',
            'address'=>'required|string',
            'role' => 'required|in:admin,employee,patient'
        ]);
        Register::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>Hash::make($request->password),
            'contact'=>$request->contact,
            'address'=>$request->address,
            'role' => $request->role,
        ]);
        return redirect('/helo')->with('success','Registration Successful. Please Login.');
    }

    // login form
    public function showLoginform()
    {
        return view('login');
    }
    // login process
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:8|max:20',
        ]);

        $user = \App\Models\Register::where('email', $request->email)->first();
        if($user && Hash::check($request->password, $user->password)){
              $request->session()->put('user_id', $user->id);
$request->session()->put('user_name', $user->name);
$request->session()->put('user_role', $user->role);

            // Auth::login($user);
            switch ($user->role) {
                case 'admin':
                    return redirect()->route('admin.dashboard')->with('success', 'Login Successful. Welcome Admin!');
                
                case 'employee':
                    return redirect()->route('employee.dashboard')->with('success', 'Login Successful. Welcome Employee!');
                
                case 'patient':
                default: 
                    return redirect()->route('patient.dashboard')->with('success', 'Login Successful. Welcome Patient!');
            }

        }
    }
    // logout
    public function logout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        session()->forget(['user_id', 'user_name', 'user_role']);
        return redirect('/')->with('success','Logged out successfully.');
    }

    public function profile(Request $request)
{
    $userId = $request->session()->get('user_id'); 

    if (!$userId) {
        return redirect('/helo')->with('error', 'Please login first.');
    }

    $user = \App\Models\Register::find($userId); 

    return view('profile', compact('user'));
}


}
