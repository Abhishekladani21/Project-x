<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{

    public function reg(){
        return view('reg');
    }

    /**
     * Display a listing of the resource.
     */
    public function dashboard()
    {
        return view('dashboard');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function login(Request $request)
    {
        $input = $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);

        if(Auth::guard('profile')->attempt($input)){
            $profile = profile::where('email', $input['email'])->first();
            Auth::guard('profile')->loginUsingId($profile->id);
            return redirect()->route('dashboard');
        }
        return back()->withErrors(['email' => 'candidates not match with our records.']);
    }

    public function logout()
    {
        Auth::logout();

        return redirect()->route('login');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
            'password_confirm' => 'required|same:password',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'password_confirm' => Hash::make($request->password_confirm),
        ];

        profile::create($data);
        return redirect(url('dashboard'));
    }

    /**
     * Display the specified resource.
     */
    public function editProfile()
    {
        // dd(25);
        $profile = Auth::user();

        return view('profile', ['users' => $profile]);
    }
    /**
     * Update the specified resource in storage.
     */
    public function updateProfile(Request $request)
    {
        $id = Auth::id();

        $request->validate([
            'name' => 'required',
            'email' => 'required|email:filter|unique:users,email,' . $id,
        ]);

        profile::where('id', $id)->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        return redirect(url('dashboard'));
    }
}
