@extends('layouts.app')

@section('content')

    <div class="w-full">
        <div class="w-full h-52 md:h-96 bg-title flex flex-col justify-center items-center">
            <h1 class="text-2xl md:text-5xl text-title">{{ __('default.welcome_message') }}</h1>
            <p class="mt-2 text-md md:text-xl text-subtitle">{{ __('default.login_to_share') }}</p>
        </div>
        <div class="flex flex-col items-center mt-8">
            <h1 class="text-4xl">{{ __('default.key_points') }}</h1>
            <div class="w-20 h-0.5 mt-2 bg-black"></div>
        </div>
        <div class="flex justify-around mt-10 w-4/5 ml-auto mr-auto">
            <div class="flex flex-col items-center w-1/3">
                <div class="w-16 h-16 md:w-40 md:h-40 flex items-center justify-center bg-blue-200 border border-dashed rounded-full border-blue-600">
                    <i data-feather="share-2" class="w-10 h-10 text-white"></i>
                </div>
                <h2 class="text-xl md:text-4xl mt-6">{{ __('default.share_title') }}</h2>
                <p class="text-md md:text-2xl mt-2 w-2/3 ml-auto mr-auto text-center">{{ __('default.share_message') }}</p>
            </div>
            <div class="flex flex-col items-center w-1/3">
                <div class="w-16 h-16 md:w-40 md:h-40 flex items-center justify-center bg-blue-200 border border-dashed rounded-full border-blue-600">
                    <i data-feather="wifi" class="w-10 h-10 text-white"></i>
                </div>
                <h2 class="text-xl md:text-4xl mt-6">{{ __('default.speed_title') }}</h2>
                <p class="text-md md:text-2xl mt-2 w-2/3 ml-auto mr-auto text-center">{{ __('default.speed_message') }}</p>
            </div>
            <div class="flex flex-col items-center w-1/3">
                <div class="w-16 h-16 md:w-40 md:h-40 flex items-center justify-center bg-blue-200 border border-dashed rounded-full border-blue-600">
                    <i data-feather="dollar-sign" class="w-10 h-10 text-white"></i>
                </div>
                <h2 class="text-xl md:text-4xl mt-6">{{ __('default.free_title') }}</h2>
                <p class="text-md md:text-2xl mt-2 w-2/3 ml-auto mr-auto text-center">{{ __('default.free_message') }}</p>
            </div>
        </div>
        <div class="w-full mt-10 bg-gray-200 flex flex-col justify-center items-center">
            <p class="mt-14 pt-6 pb-6 pl-10 md:pl-20 pr-10 md:pr-20 rounded-3xl bg-white text-2xl md:text-4xl shadow-title">{{ __('default.try_yourself') }}</p>
            <a class="mt-6 mb-14 btn-primary" href="{{ route('wishlists.create') }}">{{ __('default.create_list') }}</a>
        </div>
    </div>

@endsection
