<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB; // ✅ IMPORTANT
use App\Models\User;

class AuthController extends Controller
{
    // SHOW LOGIN PAGE
    public function showlogin()
    {
        return view('login');
    }

    // SHOW REGISTER PAGE
    public function showregister()
    {
        return view('register');
    }

    // LOGIN
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return back()->with('error', 'Invalid email or password');
        }

        // Doctor approval check
        if ($user->role === 'doctor' && !$user->is_approved) {
            return back()->with('error', 'Doctor account awaiting approval');
        }

        Auth::login($user);
        $request->session()->regenerate();

        // ✅ FORCE SET USER ONLINE (RELIABLE FIX)
        DB::table('users')
            ->where('id', Auth::id())
            ->update(['is_online' => 1]);

        return match ($user->role) {
            'admin' => redirect('/admin/dashboard'),
            'doctor' => redirect('/doctor/dashboard'),
            default => redirect('/home'),
        };
    }

    // REGISTER
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed|min:6',

            'doctor_document' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
            'profile_image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'specialization' => 'nullable|string|max:255',
            'doctor_note' => 'nullable|string|max:1000',
        ]);

        $isDoctor = $request->has('is_doctor');

        // upload profile image
        $profileImagePath = null;
        if ($request->hasFile('profile_image')) {
            $profileImagePath = $request->file('profile_image')
                ->store('profiles', 'public');
        }

        // create user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),

            'role' => $isDoctor ? 'doctor' : 'patient',
            'is_approved' => $isDoctor ? false : true,

            'profile_image' => $profileImagePath,
            'specialization' => $request->specialization,
            'doctor_note' => $request->doctor_note,
        ]);

        // upload doctor document
        
       if ($request->hasFile('doctor_document')) {

    $file = $request->file('doctor_document');

$filename = time().'_'.str_replace(' ', '_', $file->getClientOriginalName());

$path = $file->storeAs('documents', $filename, 'public');

$user->doctor_document = $path;
$user->save();

}

        // doctor flow (no auto login)
        if ($isDoctor) {
            return redirect('/login')
                ->with('success', 'Doctor account created. Awaiting admin approval.');
        }

               return redirect('/login')
    ->with('success', 'Registration successful! Please login to continue.');
    }

    // LOGOUT
    public function logout()
    {
        if (Auth::check()) {
            DB::table('users')
                ->where('id', Auth::id())
                ->update(['is_online' => 0]);
        }

        Auth::logout();

        return redirect('/login');
    }
}