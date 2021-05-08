@extends('layouts.guest')

@section('content')

    <div class="w-full h-full flex items-center justify-center bg-snow">
        <form class="w-full md:w-4/12 bg-white p-8 rounded-xl" method="POST" action="{{ route('login') }}">
            @csrf
            <div class="flex justify-between">
                <h1 class="text-3xl">{{ __('auth.login') }}</h1>
                <a class="flex items-center" href="{{ route('register') }}">{{ __('auth.register') }} <i class="ml-2" data-feather="arrow-right"></i></a>
            </div>
            <div class="mt-6">
                <label for="email" class="text-xl">{{ __('user.email') }} <span class="text-red-600">*</span></label>
                <input type="text" id="email" name="email" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50" placeholder="{{ __('user.email') }}">
                @error('email')
                    <small class="text-red-600">{{ $message }}</small>
                @enderror
            </div>
            <div class="mt-6">
                <label for="password" class="text-xl">{{ __('user.password') }} <span class="text-red-600">*</span></label>
                <input type="password" id="password" name="password" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50" placeholder="{{ __('user.password') }}">
                @error('password')
                    <small class="text-red-600">{{ $message }}</small>
                @enderror
            </div>
            <div class="flex items-center float-right mt-6">
                <a href="{{ route('password.request') }}">{{ __('auth.forgot_password') }}</a>
                <button class="btn-primary ml-4" type="submit">{{ __('auth.login') }}</button>
            </div>
        </form>
    </div>

@endsection
