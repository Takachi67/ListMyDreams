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
                buttons: {
                    home: '{{ __('buttons.home') }}',
                    myFriends: '{{ __('buttons.my_friends') }}',
                    myLists: '{{ __('buttons.my_lists') }}'
                },
                default: {
                    close: '{{ __('default.close') }}'
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
                    reserve: '{{ __('items.reserve') }}',
                    success: '{{ __('items.success') }}',
                    successfully_reserved: '{{ __('items.successfully_reserved') }}',
                    successfully_unreserved: '{{ __('items.successfully_unreserved') }}',
                    text_color: '{{ __('items.text_color') }}',
                    unreserve: '{{ __('items.unreserve') }}'
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
                    create_question: '{{ __('wishlists.create_question') }}',
                    expiration_date: '{{ __('wishlists.expiration_date') }}',
                    modify: '{{ __('wishlists.modify') }}',
                    name: '{{ __('wishlists.name') }}',
                    share: '{{ __('wishlists.share') }}',
                    sharing_type: '{{ __('wishlists.sharing_type') }}',
                    sharing_types: {
                        friends: '{{ __('wishlists.sharing_types.friends') }}',
                        selection: '{{ __('wishlists.sharing_types.selection') }}'
                    }
                }
            }

            window.routes = {
                home: '{{ route('/') }}',
                wishlist: {
                    index: '{{ route('wishlists.index') }}',
                    reserve: '{{ route('wishlists.reserve') }}',
                    store: '{{ route('wishlists.store') }}',
                    unreserve: '{{ route('wishlists.unreserve') }}'
                }
            }
        </script>

        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}" defer></script>
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen" id="main">
            <navigation></navigation>

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
                <div class="flex items-center h-20 ml-24 mr-24">
                    <p class="text-gray-400">© Copyright 2021</p>
                </div>
            </footer>
        </div>
    </body>
</html>
