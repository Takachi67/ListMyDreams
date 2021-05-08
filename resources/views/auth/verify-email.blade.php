@extends('layouts.guest')

@section('content')

    <div class="w-full h-full flex items-center justify-center bg-snow">
        <div class="w-full md:w-4/12 bg-white p-8 rounded-xl">
            @csrf
            <h1 class="text-3xl">{{ __('auth.email_verification') }}</h1>
            <div class="mt-6">
                <p>{{ __('auth.email_verification_sent') }}</p>
            </div>
            <div class="mt-6 flex items-center justify-between">
                <form method="POST" action="{{ route('verification.send') }}">
                    @csrf
                    <button class="btn-primary" type="submit">{{ __('auth.email_verification_btn_resend') }}</button>
                </form>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="btn-primary" type="submit">{{ __('auth.logout') }}</button>
                </form>
            </div>
            @if (session('status') == 'verification-link-sent')
                <div class="mt-6">
                    <p>{{ __('auth.email_verification_new_link') }}</p>
                </div>
            @endif
        </div>
    </div>

@endsection
