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
                    myLists: '{{ __('buttons.my_lists') }}',
                    myProfile: '{{ __('buttons.my_profile') }}',
                    myReservations: '{{ __('buttons.my_reservations') }}'
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
                notifications: {
                    none: '{{ __('notifications.none') }}'
                },
                questions: {
                    answer: '{{ __('questions.answer') }}',
                    answer_received: '{{ __('questions.answer_received') }}',
                    answer_saved: '{{ __('questions.answer_saved') }}',
                    ask_question: '{{ __('questions.ask_question') }}',
                    new_question: '{{ __('questions.new_question') }}',
                    none: '{{ __('questions.none') }}',
                    question: '{{ __('questions.question') }}',
                    question_is_anonymous: '{{ __('questions.question_is_anonymous') }}',
                    question_sent: '{{ __('questions.question_sent') }}',
                    your_question: '{{ __('questions.your_question') }}',
                },
                reservations: {
                    bought: '{{ __('reservations.bought') }}',
                    notes: '{{ __('reservations.notes') }}',
                    notes_saved: '{{ __('reservations.notes_saved') }}',
                    not_bought: '{{ __('reservations.not_bought') }}',
                    save_notes: '{{ __('reservations.save_notes') }}',
                    where_to_find: '{{ __('reservations.where_to_find') }}'
                },
                user: {
                    cancel_password: '{{ __('user.cancel_password') }}',
                    email: '{{ __('user.email') }}',
                    logout: '{{ __('user.logout') }}',
                    password: '{{ __('user.password') }}',
                    password_confirmation: '{{ __('user.password_confirmation') }}',
                    save: '{{ __('user.save') }}',
                    update_password: '{{ __('user.update_password') }}',
                },
                wishlists: {
                    already_reserved: '{{ __('wishlists.already_reserved') }}',
                    available: '{{ __('wishlists.available') }}',
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
                    duplicate_list: '{{ __('wishlists.duplicate_list') }}',
                    duplicate_question: '{{ __('wishlists.duplicate_question') }}',
                    expiration_date: '{{ __('wishlists.expiration_date') }}',
                    expired_creator_message: '{{ __('wishlists.expired_creator_message') }}',
                    expired_message: '{{ __('wishlists.expired_message') }}',
                    modify: '{{ __('wishlists.modify') }}',
                    name: '{{ __('wishlists.name') }}',
                    open: '{{ __('wishlists.open') }}',
                    share: '{{ __('wishlists.share') }}',
                    publish: '{{ __('wishlists.publish') }}',
                    publish_question: '{{ __('wishlists.publish_question') }}',
                    publish_subquestion: '{{ __('wishlists.publish_subquestion') }}',
                    published_message: '{{ __('wishlists.published_message') }}',
                    sharing_type: '{{ __('wishlists.sharing_type') }}',
                    sharing_types: {
                        friends: '{{ __('wishlists.sharing_types.friends') }}',
                        with_link: '{{ __('wishlists.sharing_types.with_link') }}'
                    },
                    publishing_warning: '{{ __('wishlists.publishing_warning') }}',
                    unreserve_question: '{{ __('wishlists.unreserve_question') }}',
                    update_list: '{{ __('wishlists.update_list') }}',
                    update_question: '{{ __('wishlists.update_question') }}'
                }
            }

            window.routes = {
                baseUrl: '{{ url('/') }}',
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
                notifications: {
                    see: '{{ route('notifications.see') }}'
                },
                questions: {
                    ask: '{{ route('questions.ask') }}',
                    answer: '{{ route('questions.answer') }}',
                    showAnswer: '{{ route('questions.showAnswer') }}'
                },
                reservations: {
                    hasBought: '{{ route('reservations.hasBought') }}',
                    index: '{{ route('reservations.index') }}',
                    saveNotes: '{{ route('reservations.saveNotes') }}'
                },
                users: {
                    profile: '{{ route('users.profile') }}'
                },
                wishlist: {
                    index: '{{ route('wishlists.index') }}',
                    reserve: '{{ route('wishlists.reserve') }}',
                    store: '{{ route('wishlists.store') }}',
                    update: '{{ route('wishlists.update') }}',
                    duplicate: '{{ route('wishlists.duplicate', '') }}',
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
                @isset($notifications)
                :default-notifications="{{ json_encode($notifications) }}"
                @endisset
                @isset($questions)
                :default-questions="{{ json_encode($questions) }}"
                @endisset
            ></navigation>

            <!-- Page Content -->
            <main>
                @yield('content')
            </main>

            <footer>
                <div class="w-full border-b">
                    <div class="flex justify-between items-center h-20 md:h-32 ml-4 mr-4 md:ml-24 md:mr-24">
                        <a href="{{ route('/') }}" class="h-1/2">
                            <img src="/img/logo.png" alt="Logo" class="h-full">
                        </a>
                        <div class="flex justify-around w-28 md:w-48">
                            <a href="https://twitter.com/WishuWebsite" target="_blank">
                                <i data-feather="twitter"></i>
                            </a>
                            <a href="https://www.instagram.com/wishuwebsite/" target="_blank">
                                <i data-feather="instagram"></i>
                            </a>
                            <a href="https://www.facebook.com/wishuwebsite" target="_blank">
                                <i data-feather="facebook"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="flex justify-between items-center h-10 md:h-20 ml-4 mr-4 md:ml-24 md:mr-24">
                    <span class="text-gray-400" type="submit">© Copyright 2021</span>
                    <div class="flex items-center">
                        <a href="/mentions-legales" class="underline mr-10">Mentions légales</a>
                        <a href="mailto:wishu.contact@gmail.com" class="underline">Contact</a>
                    </div>
                </div>
            </footer>
        </div>
    </body>
</html>
