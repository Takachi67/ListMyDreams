@extends('layouts.app')

@section('content')

    <div class="w-full">
        <div class="w-full h-52 md:h-96 bg-title flex flex-col justify-center items-center">
            <h1 class="text-3xl md:text-5xl text-title">{{ __('reservations.my_reservations_title') }}</h1>
        </div>
        <div class="ml-4 mr-4 md:ml-40 md:mr-40">
            @foreach($users as $name => $items)
                <wishlist-reservations
                    name="{{ $name }}"
                    :default-items="{{ json_encode($items) }}"
                ></wishlist-reservations>
            @endforeach
        </div>
    </div>

@endsection
