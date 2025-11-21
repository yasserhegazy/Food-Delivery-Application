@extends('layouts.guest')

@section('title', 'Login')

@section('content')
<x-card>
    <div class="text-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Welcome Back!</h2>
        <p class="text-gray-600 mt-1">Sign in to your account</p>
    </div>

    @if(session('error'))
        <x-alert type="error" class="mb-4">
            {{ session('error') }}
        </x-alert>
    @endif

    @if(session('success'))
        <x-alert type="success" class="mb-4">
            {{ session('success') }}
        </x-alert>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <x-input
            label="Email Address"
            name="email"
            type="email"
            placeholder="Enter your email"
            required
            :icon="'<svg class=\'w-5 h-5\' fill=\'none\' stroke=\'currentColor\' viewBox=\'0 0 24 24\'><path stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'2\' d=\'M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207\'/></svg>'"
        />

        <x-input
            label="Password"
            name="password"
            type="password"
            placeholder="Enter your password"
            required
            :icon="'<svg class=\'w-5 h-5\' fill=\'none\' stroke=\'currentColor\' viewBox=\'0 0 24 24\'><path stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'2\' d=\'M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z\'/></svg>'"
        />

        <div class="flex items-center justify-between mb-6">
            <label class="flex items-center">
                <input type="checkbox" name="remember" class="rounded border-gray-300 text-orange-500 focus:ring-orange-500">
                <span class="ml-2 text-sm text-gray-600">Remember me</span>
            </label>

            <a href="#" class="text-sm text-orange-500 hover:text-orange-600">
                Forgot password?
            </a>
        </div>

        <x-button type="submit" variant="primary" class="w-full">
            Sign In
        </x-button>
    </form>

    <div class="mt-6 text-center">
        <p class="text-sm text-gray-600">
            Don't have an account?
            <a href="{{ route('register') }}" class="text-orange-500 hover:text-orange-600 font-semibold">
                Sign up
            </a>
        </p>
    </div>
</x-card>
@endsection
