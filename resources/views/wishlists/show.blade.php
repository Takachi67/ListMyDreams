@extends('layouts.app')

@section('content')

    <div class="w-full">
        <div class="w-full h-52 md:h-96 bg-title flex flex-col justify-center items-center">
            <h1 class="text-3xl md:text-5xl text-title">{{ $wishlist->name }}</h1>
        </div>
        <wishlist
            :default-wishlist="{{ json_encode($wishlist) }}"
            :user="{{ json_encode(auth()->user()) }}"
            :can-edit="{{ $canEdit }}"
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
