@extends('layouts.app')
@section('content')
<main class="min-h-screen flex items-center justify-center bg-pamsucolo-bg">
    <div class="w-full max-w-md bg-white shadow-lg rounded-xl p-8">
        <div class="text-center mb-8">
            <img class="w-16 h-16 mx-auto mb-2" src="{{ asset('logo.png') }}" alt="PamSuCoLo Logo">
            <h2 class="text-3xl font-extrabold text-pamsucolo-primary mb-2">Login to PamSuCoLo</h2>
            <p class="text-gray-600">Access your account using your registered student number and password.</p>
        </div>
        @if($errors->any())
            <div class="mb-5 bg-red-50 border border-red-200 text-red-600 rounded p-3 text-sm">
                <ul class="list-disc ml-5">
                    @foreach($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form method="POST" action="{{ route('login') }}" class="space-y-5">
            @csrf
                    <div>
                <label for="student_number" class="block text-sm font-medium text-gray-700">Student Number</label>
                <input type="text" name="student_number" id="student_number" value="{{ old('student_number') }}" required autofocus
                               class="custom-focus mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:ring-pamsucolo-primary focus:border-pamsucolo-primary text-base">
                    </div>
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                <input type="password" name="password" id="password" required
                       class="custom-focus mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:ring-pamsucolo-primary focus:border-pamsucolo-primary text-base">
            </div>
            <button type="submit" class="w-full py-3 px-4 rounded-lg shadow-lg bg-pamsucolo-primary text-white font-bold text-base hover:bg-pamsucolo-primary/90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-pamsucolo-primary">Login</button>
        </form>
        <div class="mt-6 text-center">
            <a href="{{ route('register') }}" class="text-pamsucolo-primary hover:underline">Register a new account</a>
        </div>
        </div>
    </main>
@endsection
