<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">

        <script>
            window.translations = {
                auth: {
                    login: '{{ __('auth.login') }}'
                },
                buttons: {
                    home: '{{ __('buttons.home') }}',
                    myFriends: '{{ __('buttons.my_friends') }}',
                    myLists: '{{ __('buttons.my_lists') }}'
                },
                default: {
                    close: '{{ __('default.close') }}'
                },
                friends: {
                    accept: '{{ __('friends.accept') }}',
                    decline: '{{ __('friends.decline') }}',
                    new_request: '{{ __('friends.new_request') }}',
                    pending_requests: '{{ __('friends.pending_requests') }}',
                    remove_question: '{{ __('friends.remove_question') }}',
                    requests: '{{ __('friends.requests') }}',
                    request_accepted: '{{ __('friends.request_accepted') }}',
                    request_declined: '{{ __('friends.request_declined') }}',
                    send: '{{ __('friends.send') }}'
                },
                items: {
                    add: '{{ __('items.add') }}',
                    border_color: '{{ __('items.border_color') }}',
                    comment: '{{ __('items.comment') }}',
                    create_list: '{{ __('items.create_list') }}',
                    customization: '{{ __('items.customization') }}',
                    error: '{{ __('items.error') }}',
                    line_color: '{{ __('items.line_color') }}',
                    link: '{{ __('items.link') }}',
                    missing_properties: '{{ __('items.missing_properties') }}',
                    name: '{{ __('items.name') }}',
                    newItem: '{{ __('items.new_item') }}',
                    priority: '{{ __('items.priority') }}',
                    priorities: {
                        low: '{{ __('items.priorities.low') }}',
                        medium: '{{ __('items.priorities.medium') }}',
                        high: '{{ __('items.priorities.high') }}',
                        ultra: '{{ __('items.priorities.ultra') }}'
                    },
                    remove_from_list: '{{ __('items.remove_from_list') }}',
                    reserve: '{{ __('items.reserve') }}',
                    success: '{{ __('items.success') }}',
                    successfully_reserved: '{{ __('items.successfully_reserved') }}',
                    successfully_unreserved: '{{ __('items.successfully_unreserved') }}',
                    text_color: '{{ __('items.text_color') }}',
                    unreserve: '{{ __('items.unreserve') }}'
                },
                messenger: {
                    discussion: '{{ __('messenger.discussion') }}',
                    send: '{{ __('messenger.send') }}',
                    your_message: '{{ __('messenger.your_message') }}'
                },
                user: {
                    email: '{{ __('user.email') }}'
                },
                wishlists: {
                    category: '{{ __('wishlists.category') }}',
                    categories: {
                        anniversary: '{{ __('wishlists.categories.anniversary') }}',
                        wedding: '{{ __('wishlists.categories.wedding') }}',
                        christmas: '{{ __('wishlists.categories.christmas') }}',
                        birth: '{{ __('wishlists.categories.birth') }}',
                        communion: '{{ __('wishlists.categories.communion') }}',
                        easter: '{{ __('wishlists.categories.easter') }}',
                        other: '{{ __('wishlists.categories.other') }}'
                    },
                    create_buttons: {
                        no: '{{ __('wishlists.create_buttons.no') }}',
                        yes: '{{ __('wishlists.create_buttons.yes') }}'
                    },
                    create_list: '{{ __('wishlists.create_list') }}',
                    create_question: '{{ __('wishlists.create_question') }}',
                    expiration_date: '{{ __('wishlists.expiration_date') }}',
                    modify: '{{ __('wishlists.modify') }}',
                    name: '{{ __('wishlists.name') }}',
                    open: '{{ __('wishlists.open') }}',
                    share: '{{ __('wishlists.share') }}',
                    publish: '{{ __('wishlists.publish') }}',
                    publish_question: '{{ __('wishlists.publish_question') }}',
                    published_message: '{{ __('wishlists.published_message') }}',
                    sharing_type: '{{ __('wishlists.sharing_type') }}',
                    sharing_types: {
                        friends: '{{ __('wishlists.sharing_types.friends') }}',
                        with_link: '{{ __('wishlists.sharing_types.with_link') }}'
                    },
                    publishing_warning: '{{ __('wishlists.publishing_warning') }}',
                    update_list: '{{ __('wishlists.update_list') }}',
                    update_question: '{{ __('wishlists.update_question') }}'
                }
            }

            window.routes = {
                friends: {
                    index: '{{ route('friends.index') }}',
                    request: '{{ route('friends.request') }}',
                    accept: '{{ route('friends.accept') }}',
                    remove: '{{ route('friends.remove') }}',
                    decline: '{{ route('friends.decline') }}'
                },
                home: '{{ route('/') }}',
                login: '{{ route('login') }}',
                logout: '{{ route('logout') }}',
                messenger: {
                    send: '{{ route('messenger.send') }}'
                },
                wishlist: {
                    index: '{{ route('wishlists.index') }}',
                    reserve: '{{ route('wishlists.reserve') }}',
                    store: '{{ route('wishlists.store') }}',
                    update: '{{ route('wishlists.update') }}',
                    unreserve: '{{ route('wishlists.unreserve') }}',
                    edit: '{{ route('wishlists.edit', '') }}',
                    show: '{{ route('wishlists.show', '') }}',
                    share: '{{ route('wishlists.share') }}'
                }
            }
        </script>

        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}" defer></script>
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen" id="main">
            <navigation
                :user="{{ json_encode(auth()->user()) }}"
            ></navigation>

            <!-- Page Content -->
            <main>
                @yield('content')
            </main>

            <footer>
                <div class="w-full border-b">
                    <div class="flex justify-between items-center h-32 ml-24 mr-24">
                        <img src="/img/logo.png" alt="Logo" class="h-1/4">
                        <div class="flex justify-around w-48">
                            <i class="cursor-pointer" data-feather="twitter"></i>
                            <i class="cursor-pointer" data-feather="instagram"></i>
                            <i class="cursor-pointer" data-feather="facebook"></i>
                        </div>
                    </div>
                </div>
                <form class="flex items-center h-20 ml-24 mr-24" action="{{ route('logout') }}" method="post">
                    @csrf
                    <button class="text-gray-400" type="submit">© Copyright 2021</button>
                </form>
            </footer>
        </div>
    </body>
</html>
