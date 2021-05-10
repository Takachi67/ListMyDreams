<template>
    <nav class="w-full h-20 bg-white">
        <div class="ml-24 mr-24 h-full flex justify-between items-center">
            <img src="/img/logo.png" alt="Logo" class="h-1/2">
            <div class="h-full flex items-center">
                <a class="flex items-center pl-14 pr-14 h-full hover:bg-blue-50" :href="routes.home">{{ translations.buttons.home }}</a>
                <a class="flex items-center pl-14 pr-14 h-full hover:bg-blue-50" :href="routes.wishlist.index">{{ translations.buttons.myLists }}</a>
                <a class="flex items-center pl-14 pr-14 h-full hover:bg-blue-50" href="">{{ translations.buttons.myFriends }}</a>
            </div>
            <div class="w-16 h-16 hover:bg-blue-50 border border-blue-100 flex justify-center items-center cursor-pointer">
                <i data-feather="user" class="text-2xl text-blue-900"></i>
            </div>
        </div>
    </nav>
</template>

<script>
export default {
    name: 'Navigation',
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
