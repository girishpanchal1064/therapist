@extends('layouts.app')

@section('title', 'Create Account - TalkToAngel Clone')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
        <div>
            <div class="mx-auto h-12 w-12 bg-primary-600 rounded-lg flex items-center justify-center">
                <svg class="h-8 w-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
                Create your account
            </h2>
            <p class="mt-2 text-center text-sm text-gray-600">
                Or
                <a href="{{ route('login') }}" class="font-medium text-primary-600 hover:text-primary-500">
                    sign in to your existing account
                </a>
            </p>
        </div>
        
        <form class="mt-8 space-y-6" method="POST" action="{{ route('register') }}">
            @csrf
            
            <div class="space-y-4">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">
                        Full Name
                    </label>
                    <div class="mt-1">
                        <input id="name" 
                               name="name" 
                               type="text" 
                               autocomplete="name" 
                               required 
                               value="{{ old('name') }}"
                               class="form-input @error('name') border-red-300 @enderror"
                               placeholder="Enter your full name">
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">
                        Email address
                    </label>
                    <div class="mt-1">
                        <input id="email" 
                               name="email" 
                               type="email" 
                               autocomplete="email" 
                               required 
                               value="{{ old('email') }}"
                               class="form-input @error('email') border-red-300 @enderror"
                               placeholder="Enter your email">
                        @error('email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                
                <div>
                    <label for="phone" class="block text-sm font-medium text-gray-700">
                        Phone Number (Optional)
                    </label>
                    <div class="mt-1">
                        <input id="phone" 
                               name="phone" 
                               type="tel" 
                               autocomplete="tel" 
                               value="{{ old('phone') }}"
                               class="form-input @error('phone') border-red-300 @enderror"
                               placeholder="Enter your phone number">
                        @error('phone')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                
                <div>
                    <label for="role" class="block text-sm font-medium text-gray-700">
                        I am a
                    </label>
                    <div class="mt-1">
                        <select id="role" 
                                name="role" 
                                required
                                class="form-select @error('role') border-red-300 @enderror">
                            <option value="">Select your role</option>
                            <option value="client" {{ old('role') == 'client' ? 'selected' : '' }}>Client/Patient</option>
                            <option value="therapist" {{ old('role') == 'therapist' ? 'selected' : '' }}>Therapist/Doctor</option>
                            <option value="corporate_admin" {{ old('role') == 'corporate_admin' ? 'selected' : '' }}>Corporate Admin</option>
                        </select>
                        @error('role')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">
                        Password
                    </label>
                    <div class="mt-1">
                        <input id="password" 
                               name="password" 
                               type="password" 
                               autocomplete="new-password" 
                               required
                               class="form-input @error('password') border-red-300 @enderror"
                               placeholder="Create a password">
                        @error('password')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700">
                        Confirm Password
                    </label>
                    <div class="mt-1">
                        <input id="password_confirmation" 
                               name="password_confirmation" 
                               type="password" 
                               autocomplete="new-password" 
                               required
                               class="form-input"
                               placeholder="Confirm your password">
                    </div>
                </div>
            </div>

            <div class="flex items-center">
                <input id="terms" 
                       name="terms" 
                       type="checkbox" 
                       required
                       class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300 rounded">
                <label for="terms" class="ml-2 block text-sm text-gray-900">
                    I agree to the 
                    <a href="#" class="text-primary-600 hover:text-primary-500">Terms of Service</a> 
                    and 
                    <a href="#" class="text-primary-600 hover:text-primary-500">Privacy Policy</a>
                </label>
            </div>

            <div>
                <button type="submit" class="btn-primary w-full">
                    Create Account
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
