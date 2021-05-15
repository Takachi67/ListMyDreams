@extends('layouts.app')

@section('content')

    <div class="w-full">
        <div class="w-full h-52 md:h-96 bg-title flex flex-col justify-center items-center">
            <h1 class="text-3xl md:text-5xl text-title">{{ __('wishlists.my_lists_title') }}</h1>
        </div>
        <div class="flex flex-col items-center mt-10 mb-10">
            <a href="{{ route('wishlists.create') }}" class="btn custom-btn-primary pl-16 pr-16 pt-3 pb-3">{{ __('wishlists.create_a_list') }}</a>
            <div class="w-1/4 border border-b-2 mt-10"></div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6 ml-20 mr-20">
            @foreach($lists as $list)
                <list-view
                    :default-wishlist="{{ json_encode($list) }}"
                    :friends="{{ json_encode($friends) }}"
                ></list-view>
            @endforeach
        </div>
    </div>

@endsection
