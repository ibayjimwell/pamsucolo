<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Illuminate\Support\Facades\Cache;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle the final registration request.
     */
    public function store(Request $request): RedirectResponse
    {
        $verified = session('verified_student');
        if (!$verified || empty($verified['student_number'])) {
            return redirect()->route('register')->withErrors(['verification' => 'Please verify your student credentials before registering.']);
        }
        // Register only with student_number; prevent duplicates
        $user = 
            \App\Models\User::firstOrCreate([
                'student_number' => $verified['student_number'],
            ]);
        \Illuminate\Support\Facades\Auth::login($user);
        return redirect('/');
    }
}