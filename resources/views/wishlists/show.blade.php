@extends('layouts.app')

@section('content')

    <div class="w-full">
        <div class="w-full h-52 md:h-96 bg-title flex flex-col justify-center items-center">
            <h1 class="text-3xl md:text-5xl text-title">{{ $wishlist->name }}</h1>
        </div>
        @if(auth()->user() && auth()->user()->getAuthIdentifier() === $wishlist->user_id)
            <div class="mb-5 mt-10 ml-10 md:ml-20">
                <a class="btn btn-secondary" href="{{ route('wishlists.edit', $wishlist->id) }}">{{ __('wishlists.modify') }}</a>
            </div>
        @endif
        <wishlist
            :default-wishlist="{{ json_encode($wishlist) }}"
            :user="{{ json_encode(auth()->user()) }}"
            :can-edit="{{ $canEdit ? 'true' : 'false' }}"
        ></wishlist>
        @if($canEdit)
            <messenger
                :list="{{ json_encode($wishlist) }}"
                :user="{{ json_encode(auth()->user()) }}"
                :default-messages="{{ json_encode($wishlist->messages) }}"
            ></messenger>
        @endif
    </div>

@endsection
