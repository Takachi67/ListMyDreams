<template>
    <nav class="w-full h-20 bg-white">
        <div class="ml-24 mr-24 h-full flex justify-between items-center">
            <a class="h-1/2" :href="routes.home">
                <img src="/img/logo.png" alt="Logo" class="h-full">
            </a>
            <div class="h-full flex items-center">
                <a class="flex items-center pl-14 pr-14 h-full hover:bg-blue-50" v-if="user" :href="routes.wishlist.index">{{ translations.buttons.myLists }}</a>
                <a class="flex items-center pl-14 pr-14 h-full hover:bg-blue-50" v-if="user" :href="routes.friends.index">{{ translations.buttons.myFriends }}</a>
            </div>
            <div v-if="user" class="w-16 h-16 hover:bg-blue-50 border border-blue-100 flex justify-center items-center cursor-pointer">
                <i data-feather="user" class="text-2xl text-blue-900"></i>
            </div>
            <a :href="routes.login" class="underline font-bold" v-else>{{ translations.auth.login }}</a>
        </div>
    </nav>
</template>

<script>
export default {
    name: 'Navigation',
    props: {
        user: {
            type: Object,
            default: {}
        }
    },
    setup() {
        let routes = window.routes,
            translations = window.translations

        return {
            routes,
            translations
        }
    }
}
</script>

<style scoped>

</style>
