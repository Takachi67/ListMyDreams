@extends('layouts.app')

@section('content')

    <div class="w-full">
        <div class="w-full h-52 md:h-96 bg-title flex flex-col justify-center items-center">
            <h1 class="text-3xl md:text-5xl text-title">{{ __('user.my_profile') }}</h1>
        </div>
        @if(\Illuminate\Support\Facades\Session::has('success'))
        <div class="w-1/2 ml-auto mr-auto flex justify-center items-center m-1 font-medium py-1 px-2 bg-white rounded-md text-green-700 bg-green-100 border border-green-300 ">
            <div class="text-xl font-normal  max-w-full flex-initial">
                {{ \Illuminate\Support\Facades\Session::get('success') }}
            </div>
        </div>
        @endif
        <form method="POST" action="{{ route('users.update') }}" enctype="multipart/form-data" class="w-11/12 md:w-1/2 ml-auto mr-auto mt-10 mb-10">
            @csrf
            <div class="w-full flex flex-col items-center">
                <div class="w-32 h-32 @if(!auth()->user()->picture) border border-blue-100 @endif flex justify-center items-center">
                    @if(auth()->user()->picture)
                    <img class="w-full h-full" src="{{ url('storage/users/' . auth()->user()->picture) }}" alt="">
                    @else
                    <i data-feather="user" class="text-blue-900"></i>
                    @endif
                </div>
                <h2 class="font-bold text-3xl mt-3">{{ auth()->user()->nickname }}</h2>
            </div>
            <div class="grid grid-cols-1 mt-5">
                <div class="flex flex-col mt-3">
                    <label class="text-xl">{{ __('user.nickname') }}</label>
                    <input type="text" value="{{ auth()->user()->nickname }}" class="col-span-2 rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50" name="nickname" placeholder="{{ __('user.nickname') }}">
                    @error('nickname')
                    <small class="text-red-700">{{ $message }}</small>
                    @enderror
                </div>
                <div class="flex flex-col mt-3">
                    <label class="text-xl">{{ __('user.email') }}</label>
                    <input type="text" value="{{ auth()->user()->email }}" class="col-span-2 rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 disabled:opacity-50" disabled>
                </div>
                <div class="flex flex-col mt-3">
                    <label for="picture" class="text-xl">{{ __('user.picture') }}</label>
                    <label class="flex flex-col items-center px-4 py-6 bg-white rounded-lg shadow-lg tracking-wide uppercase border border-blue cursor-pointer hover:bg-blue hover:text-blue-400">
                        <svg class="w-8 h-8" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                            <path d="M16.88 9.1A4 4 0 0 1 16 17H5a5 5 0 0 1-1-9.9V7a3 3 0 0 1 4.52-2.59A4.98 4.98 0 0 1 17 8c0 .38-.04.74-.12 1.1zM11 11h3l-4-4-4 4h3v3h2v-3z" />
                        </svg>
                        <span class="mt-2 text-base leading-normal">{{ __('user.select_file') }}</span>
                        <input type="file" name="picture" class="hidden" />
                    </label>
                    @error('picture')
                    <small class="text-red-700">{{ $message }}</small>
                    @enderror
                </div>
            </div>
            <password
                @error('password')
                error="{{ $message }}"
                @enderror
            ></password>
        </form>
        <form class="w-full flex justify-center mb-10" action="{{ route('logout') }}" method="POST">
            @csrf
            <button class="btn btn-secondary" type="submit">{{ __('user.logout') }}</button>
        </form>
    </div>

@endsection
