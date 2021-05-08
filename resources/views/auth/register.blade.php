@extends('layouts.guest')

@section('content')

    <div class="w-full h-full flex items-center justify-center bg-snow">
        <form class="w-full md:w-4/12 bg-white p-8 rounded-xl" method="POST" action="{{ route('register') }}">
            @csrf
            <div class="flex justify-between">
                <h1 class="text-3xl">{{ __('auth.register') }}</h1>
                <a class="flex items-center" href="{{ route('login') }}">{{ __('auth.login') }} <i class="ml-2" data-feather="arrow-right"></i></a>
            </div>
            <div class="mt-6">
                <label for="nickname" class="text-xl">{{ __('user.nickname') }} <span class="text-red-600">*</span></label>
                <input type="text" id="nickname" name="nickname" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50" placeholder="{{ __('user.nickname') }}" required>
                @error('nickname')
                    <small class="text-red-600">{{ $message }}</small>
                @enderror
            </div>
            <div class="mt-6">
                <label for="email" class="text-xl">{{ __('user.email') }} <span class="text-red-600">*</span></label>
                <input type="text" id="email" name="email" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50" placeholder="{{ __('user.email') }}" required>
                @error('email')
                    <small class="text-red-600">{{ $message }}</small>
                @enderror
            </div>
            <div class="mt-6">
                <label for="password" class="text-xl">{{ __('user.password') }} <span class="text-red-600">*</span></label>
                <input type="password" id="password" name="password" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50" placeholder="{{ __('user.password') }}" required>
                @error('password')
                    <small class="text-red-600">{{ $message }}</small>
                @enderror
            </div>
            <div class="mt-6">
                <label for="password_confirmation" class="text-xl">{{ __('user.password_confirmation') }} <span class="text-red-600">*</span></label>
                <input type="password" id="password_confirmation" name="password_confirmation" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50" placeholder="{{ __('user.password_confirmation') }}" required>
                @error('password_confirmation')
                    <small class="text-red-600">{{ $message }}</small>
                @enderror
            </div>
            <div class="flex items-center float-right mt-6">
                <button class="btn-primary ml-4" type="submit">{{ __('auth.register') }}</button>
            </div>
        </form>
    </div>

@endsection
