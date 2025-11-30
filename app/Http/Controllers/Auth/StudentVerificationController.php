<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Student;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;
use App\Mail\StudentVerificationOtp;
use Illuminate\Validation\ValidationException;

class StudentVerificationController extends Controller
{
    // Mock Portal Auth Check (Replace with actual external API call)
    private function mockPortalAuth(Student $student, $password)
    {
        // In a real application, you would make an API call to the student portal
        // For this scenario, we check if the password matches the one stored in the students table
        return Hash::check($password, $student->password);
    }

    // Generates a 4-digit OTP
    private function generateOtp()
    {
        return str_pad(random_int(1000, 9999), 4, '0', STR_PAD_LEFT);
    }

    /**
     * Handles the 'Send Code' request: verifies student, mocks portal auth, and sends OTP.
     */
    public function sendOtp(Request $request)
    {
        $request->validate([
            'student_number' => ['required', 'string', 'max:255', 'exists:students,student_number'],
            'portal_password' => ['required', 'string'],
        ], [
            'student_number.exists' => 'The student number provided is not recognized in our records.',
        ]);

        $student = Student::where('student_number', $request->student_number)->first();
        
        // Check if a User account already exists for this student
        if ($student->user()->exists()) {
             throw ValidationException::withMessages([
                'student_number' => ['An account for this student number already exists. Please login.'],
            ]);
        }
        
        // Mock Portal Authentication Check
        if (!$this->mockPortalAuth($student, $request->portal_password)) {
            // In a real system, this would be an API call failure
            throw ValidationException::withMessages([
                'portal_password' => ['The portal account password provided is incorrect.'],
            ]);
        }

        // Generate and Cache OTP (valid for 5 minutes)
        $otp = $this->generateOtp();
        $cacheKey = 'otp_' . $student->student_number;
        Cache::put($cacheKey, $otp, now()->addMinutes(5));

        // Send Email (You need to define the Mailable: App\Mail\StudentVerificationOtp)
        try {
            // Mail::to($student->email)->send(new StudentVerificationOtp($otp));
            // For development, just log the OTP
            info("OTP for {$student->student_number} ({$student->email}): {$otp}");
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to send OTP email. Please contact support.', 
                'error' => $e->getMessage()
            ], 500);
        }

        return response()->json([
            'message' => 'OTP sent successfully.',
            'email' => $student->email,
        ]);
    }

    /**
     * Handles the 'Verify Credentials' request: checks OTP against cache.
     */
    public function checkOtp(Request $request)
    {
        $request->validate([
            'student_number' => ['required', 'string', 'max:255', 'exists:students,student_number'],
            'otp_code' => ['required', 'digits:4'],
        ]);

        $cacheKey = 'otp_' . $request->student_number;
        $storedOtp = Cache::get($cacheKey);

        if (!$storedOtp || $storedOtp !== $request->otp_code) {
            return response()->json([
                'verified' => false,
                'message' => 'Invalid or expired verification code.',
            ], 400);
        }

        // OTP is valid. Clear it and fetch student data.
        Cache::forget($cacheKey);
        $student = Student::where('student_number', $request->student_number)->first();
        
        // Cache the student's ID as verified to prevent re-verification
        Cache::put('verified_student_' . $student->id, true, now()->addMinutes(15));


        return response()->json([
            'verified' => true,
            'message' => 'Credentials verified.',
            'student' => $student,
        ]);
    }

    /**
     * Verifies student credentials and fetches the student data for registration auto-population.
     * Route: POST user/verify (AJAX from registration form)
     */
    public function verifyStudent(Request $request)
    {
        $request->validate([
            'student_number' => ['required', 'string', 'max:255', 'exists:students,student_number'],
            'portal_password' => ['required', 'string'],
        ]);

        $student = Student::where('student_number', $request->student_number)->first();

        // Check password (portal password, hashed)
        if (!$student || !$this->mockPortalAuth($student, $request->portal_password)) {
            return response()->json([
                'success' => false,
                'message' => 'Student number or portal password did not match our records.',
            ], 422);
        }

        // If valid, return essential student info
        return response()->json([
            'success' => true,
            'student' => [
                'first_name' => $student->first_name,
                'middle_name' => $student->middle_name,
                'last_name' => $student->last_name,
                'current_campus' => $student->current_campus,
                'current_course' => $student->current_course,
                'current_year_level' => $student->current_year_level,
                'current_section' => $student->current_section,
                'email' => $student->email,
            ],
        ]);
    }

    /**
     * Handles the registration verify credentials POST (server-side, not AJAX).
     */
    public function verifyRegisterCredentials(Request $request)
    {
        $validated = $request->validate([
            'student_number' => ['required', 'string', 'max:255', 'exists:students,student_number'],
            'portal_password' => ['required', 'string'],
        ]);

        $student = Student::where('student_number', $validated['student_number'])->first();

        if (!$student || !$this->mockPortalAuth($student, $validated['portal_password'])) {
            return redirect()->back()->withInput()->withErrors(['verification' => 'Student number or portal password did not match our records.']);
        }
        // Store verified student info in the SESSION, not just as a flash message
        session(['verified_student' => [
            'first_name' => $student->first_name,
            'middle_name' => $student->middle_name,
            'last_name' => $student->last_name,
            'current_campus' => $student->current_campus,
            'current_course' => $student->current_course,
            'current_year_level' => $student->current_year_level,
            'current_section' => $student->current_section,
            'email' => $student->email,
            'student_number' => $student->student_number,
            // Only if you want to use password hash for future steps (not generally recommended to expose in session)
            //'password' => $student->password,
        ]]);
        return redirect()->back();
    }
}