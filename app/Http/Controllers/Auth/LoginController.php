<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }
    public function login(Request $request)
    {
        $request->validate([
            'student_number' => ['required','exists:students,student_number'],
            'password' => ['required'],
        ]);
        $student = \App\Models\Student::where('student_number', $request->student_number)->first();
        if(!$student || !\Illuminate\Support\Facades\Hash::check($request->password, $student->password)) {
            return back()->withErrors(['student_number' => 'The student number or password is incorrect.'])->withInput(['student_number']);
        }
        $user = \App\Models\User::where('student_number', $student->student_number)->first();
        if (!$user) {
            return back()->withErrors(['student_number' => 'No user account found for this student number.'])->withInput(['student_number']);
        }
        Auth::login($user);
        return redirect()->intended('/');
    }
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
