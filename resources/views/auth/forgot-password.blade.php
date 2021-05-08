@extends('layouts.guest')

@section('content')

    <div class="w-full h-full flex items-center justify-center bg-snow">
        <form class="w-full md:w-4/12 bg-white p-8 rounded-xl" method="POST" action="{{ route('password.email') }}">
            @csrf
            <div class="flex justify-between">
                <h1 class="text-3xl">{{ __('auth.forgot_password_title') }}</h1>
                <a class="flex items-center" href="{{ route('login') }}">{{ __('auth.login') }} <i class="ml-2" data-feather="arrow-right"></i></a>
            </div>
            <div class="mt-6">
                @if(session('status'))
                    <p>{{ session('status') }}</p>
                @else
                    <p>{{ __('auth.forgot_password_question') }}</p>
                @endif
            </div>
            <div class="mt-6">
                <label for="email" class="text-xl">{{ __('user.email') }} <span class="text-red-600">*</span></label>
                <input type="text" id="email" name="email" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50" placeholder="{{ __('user.email') }}">
                @error('email')
                    <small class="text-red-600">{{ $message }}</small>
                @enderror
            </div>
            <div class="flex items-center float-right mt-6">
                <button class="btn-primary ml-4" type="submit">{{ __('auth.forgot_password_title') }}</button>
            </div>
        </form>
    </div>

@endsection
