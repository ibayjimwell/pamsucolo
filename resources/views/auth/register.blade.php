<x-auth-layout>

   <header class="sticky top-0 z-10 bg-white shadow-sm border-b border-gray-100">
        <div class="max-w-xl mx-auto px-4 sm:px-6 h-16 flex items-center">
            <button onclick="history.back()" class="p-2 text-gray-700 hover:text-pamsucolo-primary focus:outline-none">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-left"><path d="m12 19-7-7 7-7"/><path d="M19 12H5"/></svg>
            </button>
            <h1 class="text-lg font-semibold ml-4">Register Student Account</h1>
        </div>
    </header>

    <main class="flex-grow flex items-center justify-center p-4 max-w-7xl mx-auto">
        <div class="w-full max-w-xl">
            <div class="text-center mb-8">
                <img class="w-16 h-16 mx-auto mb-2" src="{{ asset('logo.png') }}" alt="PamSuCoLo Logo">
                <h2 class="text-3xl font-extrabold text-pamsucolo-primary">PamSuCoLo</h2>
                <p class="text-gray-600 mt-1">Register using your Student Portal credentials.</p>
            </div>

            <!-- FLASH MESSAGES -->
            @if ($errors->any())
                <div class="mb-4">
                    <div class="bg-red-50 border border-red-200 text-red-600 rounded p-4 text-sm">
                        <ul class="list-disc ml-5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif
            @if (session('verified_student'))
                <div class="mb-4">
                    <div class="bg-green-50 border border-green-200 text-green-900 rounded p-4 text-sm">
                        Student verified. Please continue with registration.
                    </div>
                </div>
            @endif

            <div class="bg-white p-6 sm:p-8 rounded-xl shadow-2xl border border-gray-100 mb-8">
                <!-- FORM 1: VERIFY STUDENT CREDENTIALS -->
                <form class="space-y-6" method="POST" action="{{ route('student.verifyRegisterCredentials') }}">
                    @csrf
                    <h3 class="text-xl font-bold border-b pb-3 text-gray-800">Required Credentials</h3>

                    <div>
                        <label for="student-no" class="block text-sm font-medium text-gray-700">Student No. (e.g., 19288374643)</label>
                        <input type="text" id="student-no" name="student_number" required 
                            value="{{ old('student_number', session('verified_student.student_number')) }}"
                            class="custom-focus mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:ring-pamsucolo-primary focus:border-pamsucolo-primary text-base">
                    </div>
                    <div>
                        <label for="portal-password" class="block text-sm font-medium text-gray-700">Portal Account Password</label>
                        <input type="password" id="portal-password" name="portal_password" required
                            value="{{ $v['password'] ?? '' }}"
                            class="custom-focus mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-pamsucolo-primary focus:border-pamsucolo-primary text-base">
                        <p class="mt-1 text-xs text-red-500 flex items-center">
                            <svg class="w-3 h-3 mr-1" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22c5.523 0 10-4.477 10-10S17.523 2 12 2 2 6.477 2 12s4.477 10 10 10z"/><path d="M12 8v4"/><path d="M12 16h.01"/></svg>
                            <span>**Note:** Your password to your student portal SMS.</span>
                        </p>
                    </div>
                    <div>
                        <button type="submit" class="w-full flex justify-center items-center py-3 px-4 border border-transparent rounded-lg shadow-lg text-base font-bold text-white bg-pamsucolo-primary hover:bg-pamsucolo-primary/90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-pamsucolo-primary transition">
                            <svg class="w-5 h-5 mr-2" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                            Verify
                        </button>
                    </div>
                </form>
            </div>

            <div class="bg-white p-6 sm:p-8 rounded-xl shadow-2xl border border-gray-100">
                <!-- FORM 2: REGISTER ACCOUNT -->
                <form class="space-y-6" method="POST" action="{{ route('register') }}">
                    @csrf
                    <h3 class="text-xl font-bold text-gray-800 mb-4">Auto-Generated Info</h3>
                    @php $v = session('verified_student', []); @endphp
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <div class="sm:col-span-1">
                            <label for="first-name" class="block text-sm font-medium text-gray-700">First Name</label>
                            <input type="text" id="first-name" disabled value="{{ $v['first_name'] ?? '' }}"
                                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm disabled-input text-base">
                        </div>
                        <div class="sm:col-span-1">
                            <label for="middle-name" class="block text-sm font-medium text-gray-700">Middle Name</label>
                            <input type="text" id="middle-name" disabled value="{{ $v['middle_name'] ?? '' }}" 
                                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm disabled-input text-base">
                        </div>
                        <div class="sm:col-span-1">
                            <label for="last-name" class="block text-sm font-medium text-gray-700">Last Name</label>
                            <input type="text" id="last-name" disabled value="{{ $v['last_name'] ?? '' }}" 
                                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm disabled-input text-base">
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="campus" class="block text-sm font-medium text-gray-700">Campus</label>
                            <input type="text" id="campus" disabled value="{{ $v['current_campus'] ?? '' }}"
                                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm disabled-input text-base">
                        </div>
                        <div>
                            <label for="course" class="block text-sm font-medium text-gray-700">Course</label>
                            <input type="text" id="course" disabled value="{{ $v['current_course'] ?? '' }}"
                                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm disabled-input text-base">
                        </div>
                        <div>
                            <label for="year" class="block text-sm font-medium text-gray-700">Year Level</label>
                            <input type="text" id="year" disabled value="{{ $v['current_year_level'] ?? '' }}"
                                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm disabled-input text-base">
                        </div>
                        <div>
                            <label for="section" class="block text-sm font-medium text-gray-700">Section</label>
                            <input type="text" id="section" disabled value="{{ $v['current_section'] ?? '' }}"
                                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm disabled-input text-base">
                        </div>
                    </div>
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">Email Address</label>
                        <input type="email" id="email" name="email" disabled value="{{ $v['email'] ?? '' }}"
                            class="custom-focus mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:ring-pamsucolo-primary focus:border-pamsucolo-primary text-base">
                    </div>
                    <!-- Register button only enabled if student is verified -->
                    <div>
                        <button type="submit" class="w-full flex justify-center items-center py-3 px-4 border border-transparent rounded-lg shadow-lg text-base font-bold text-white bg-pamsucolo-primary hover:bg-pamsucolo-primary/90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-pamsucolo-primary transition" {{ session('verified_student') ? '' : 'disabled'}}>
                            <svg class="w-5 h-5 mr-2" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                            Register Account
                        </button>
                    </div>
                    <div class="text-center pt-2">
                        <p class="text-sm text-gray-600">
                            Already have an account? 
                            <a href="{{ route('login') }}" class="font-medium text-pamsucolo-primary hover:text-pamsucolo-primary/80 transition">
                                Log in here
                            </a>
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </main>
</x-auth-layout>