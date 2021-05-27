@extends('layouts.app')

@section('content')

    <div class="w-full">
        <div class="w-full h-52 md:h-96 bg-title flex flex-col justify-center items-center">
            <h1 class="text-3xl md:text-5xl text-title">{{ __('friends.my_friends') }}</h1>
        </div>
        <div class="ml-4 mr-4 md:ml-40 md:mr-40">
            <requests
                :default-requests="{{ json_encode($requests) }}"
            ></requests>
            @foreach($friends as $friend)
                <friend
                    :friend="{{ json_encode($friend) }}"
                ></friend>
            @endforeach
        </div>
    </div>

@endsection
