@extends('layouts.app')

@section('content')

    <div class="w-full">
        <div class="w-full h-96 bg-title flex flex-col justify-center items-center">
            <h1 class="text-5xl text-title">{{ __('wishlists.create_title') }}</h1>
        </div>
        <wishlist></wishlist>
    </div>

@endsection
