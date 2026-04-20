@extends('layouts.auth')

@section('title', 'Register')

@section('content')
<div class="bg-white p-8 rounded-2xl shadow-lg w-full max-w-md border border-gray-50">
    <h2 class="text-2xl font-bold mb-6 text-center text-gray-800">Register</h2>
    
    <form action="{{ route('register.post') }}" method="POST" class="space-y-5">
        @csrf
        <div>
            <label class="block text-sm font-medium text-gray-600 mb-1">Name:</label>
            <input type="text" name="name" value="{{ old('name') }}" 
                class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-primary/50 focus:border-primary outline-none transition">
            @error('name') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
        </div>
        
        <div>
            <label class="block text-sm font-medium text-gray-600 mb-1">Email:</label>
            <input type="email" name="email" value="{{ old('email') }}" 
                class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-primary/50 focus:border-primary outline-none transition">
            @error('email') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-600 mb-1">Password:</label>
            <input type="password" name="password" 
                class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-primary/50 focus:border-primary outline-none transition">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-600 mb-1">Confirm Password:</label>
            <input type="password" name="password_confirmation" 
                class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-primary/50 focus:border-primary outline-none transition">
        </div>

        <button type="submit" 
            class="w-full bg-primary  text-white font-bold py-3 rounded-lg shadow-md transition duration-200 transform active:scale-95">
            Register
        </button>
    </form>
</div>
@endsection