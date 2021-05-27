<template>
    <nav class="hidden md:block w-full h-20 bg-white">
        <div class="ml-24 mr-24 h-full flex justify-between items-center">
            <a class="h-3/4" :href="routes.home">
                <img src="/img/logo.png" alt="Logo" class="h-full">
            </a>
            <div class="h-full flex items-center">
                <a class="flex items-center pl-14 pr-14 h-full hover:bg-blue-50" v-if="user" :href="routes.wishlist.index">{{ translations.buttons.myLists }}</a>
                <a class="flex items-center pl-14 pr-14 h-full hover:bg-blue-50" v-if="user" :href="routes.friends.index">{{ translations.buttons.myFriends }}</a>
            </div>
            <div class="flex items-center">
                <button v-if="user" class="mr-16 relative focus:outline-none" @click="switchNotifications">
                    <i v-html="notificationIcon"></i>
                    <span class="absolute rounded-full bg-secondary text-white pastille">{{ filteredNotifications.length }}</span>
                </button>
                <a :href="routes.users.profile" v-if="user && !user.picture" class="w-16 h-16 hover:bg-blue-50 border border-blue-100 flex justify-center items-center cursor-pointer">
                    <i data-feather="user" class="text-2xl text-blue-900"></i>
                </a>
                <a :href="routes.users.profile" v-if="user && user.picture" class="w-16 h-16 hover:bg-blue-50 flex justify-center items-center cursor-pointer">
                    <img class="w-full h-full" :src="routes.baseUrl + '/storage/users/' + user.picture" alt="">
                </a>
                <a :href="routes.login" class="underline font-bold" v-if="!user">{{ translations.auth.login }}</a>
            </div>
        </div>
        <ul class="z-10 absolute top-20 right-0 w-full max-h-52 md:w-1/4 border-blue-100 border-t border-b" v-show="showNotifications">
            <li v-if="filteredNotifications.length === 0" class="w-full h-full h-10 bg-white border-blue-100 border">
                <span class="block w-full h-full p-5">{{ he.decode(translations.notifications.none) }}</span>
            </li>
            <li v-for="notification in filteredNotifications" class="w-full h-full bg-white border-blue-100 border">
                <div v-if="notification.link" class="grid grid-cols-10 flex justify-between items-center">
                    <a class="hover:bg-blue-50 col-span-8 h-full flex items-center p-5" :href="notification.link"><i class="mr-3" v-html="getNotificationIcon(notification.type)"></i> {{ he.decode(notification.message) }}</a>
                    <button @click="seeNotification(notification.id)" class="hover:bg-secondary hover:text-white col-span-2 flex justify-center items-center h-full w-full">
                        <i v-html="removeNotificationIcon"></i>
                    </button>
                </div>
                <div v-else class="grid grid-cols-10 flex justify-between items-center">
                    <span class="hover:bg-blue-50 col-span-8 h-full flex items-center p-5"><i class="mr-3" v-html="getNotificationIcon(notification.type)"></i> {{ he.decode(notification.message) }}</span>
                    <button @click="seeNotification(notification.id)" class="hover:bg-secondary hover:text-white col-span-2 flex justify-center items-center h-full w-full">
                        <i v-html="removeNotificationIcon"></i>
                    </button>
                </div>
            </li>
        </ul>
    </nav>
    <nav class="md:hidden block relative w-full h-14 bg-white">
        <div class="ml-4 mr-4 h-full flex justify-between items-center">
            <a class="h-2/3" :href="routes.home">
                <img src="/img/logo.png" alt="Logo" class="h-full">
            </a>
            <div class="flex items-center">
                <button v-if="user" class="bell-mobile mr-10 relative focus:outline-none" @click="switchNotifications">
                    <i v-html="notificationIcon"></i>
                    <span class="absolute rounded-full bg-secondary text-white pastille-mobile text-sm">{{ filteredNotifications.length }}</span>
                </button>
                <button @click="switchMenu" :class="['transition duration-200', showMenu ? 'transform rotate-90' : '']">
                    <i :class="['text-blue-600']" v-html="menuIcon"></i>
                </button>
            </div>
        </div>
        <ul class="absolute top-14 left-0 w-full border-blue-100 border-t border-b" v-show="showMenu">
            <li class="w-full h-full h-10 bg-white border-blue-100 border" v-if="user">
                <a class="block w-full h-full p-5" :href="routes.wishlist.index">{{ translations.buttons.myLists }}</a>
            </li>
            <li class="w-full h-full h-10 bg-white border-blue-100 border" v-if="user">
                <a class="block w-full h-full p-5" :href="routes.friends.index">{{ translations.buttons.myFriends }}</a>
            </li>
            <li class="w-full h-full h-10 bg-white border-blue-100 border" v-if="user">
                <a class="block w-full h-full p-5" :href="routes.users.profile">{{ translations.buttons.myProfile }}</a>
            </li>
            <li class="w-full h-full h-10 bg-white border-blue-100 border" v-else>
                <a class="block w-full h-full p-5" :href="routes.login">{{ translations.auth.login }}</a>
            </li>
        </ul>
        <ul class="z-10 absolute top-14 right-0 w-full max-h-52 border-blue-100 border-t border-b" v-show="showNotifications">
            <li v-if="filteredNotifications.length === 0" class="w-full h-full h-10 bg-white border-blue-100 border">
                <span class="block w-full h-full p-5">{{ he.decode(translations.notifications.none) }}</span>
            </li>
            <li v-for="notification in filteredNotifications" class="w-full h-full bg-white border-blue-100 border">
                <div v-if="notification.link" class="grid grid-cols-10 flex justify-between items-center">
                    <a class="hover:bg-blue-50 col-span-8 h-full p-5" :href="notification.link"><i class="mr-3" v-html="getNotificationIcon(notification.type)"></i> {{ he.decode(notification.message) }}</a>
                    <button @click="seeNotification(notification.id)" class="hover:bg-secondary hover:text-white col-span-2 flex justify-center items-center h-full w-full">
                        <i v-html="removeNotificationIcon"></i>
                    </button>
                </div>
                <div v-else class="grid grid-cols-10 flex justify-between items-center">
                    <span class="hover:bg-blue-50 col-span-8 h-full p-5"><i class="mr-3" v-html="getNotificationIcon(notification.type)"></i> {{ he.decode(notification.message) }}</span>
                    <button @click="seeNotification(notification.id)" class="hover:bg-secondary hover:text-white col-span-2 flex justify-center items-center h-full w-full">
                        <i v-html="removeNotificationIcon"></i>
                    </button>
                </div>
            </li>
        </ul>
    </nav>
    <div v-if="showNotifications" class="outside" v-on:click="clickOutsideNotifications"></div>
</template>

<script>
import { computed, ref } from 'vue'
import feather from 'feather-icons'
import axios from 'axios'

export default {
    name: 'Navigation',
    props: {
        user: {
            type: Object,
            default: {}
        },
        defaultNotifications: {
            type: Array,
            default: []
        }
    },
    setup(props) {
        let routes = window.routes,
            translations = window.translations,
            he = window.he,
            notifications = ref(props.defaultNotifications),
            showMenu = ref(false),
            showNotifications = ref(false),
            isLoading = ref(false)

        const menuIcon = computed(() => {
            return feather.icons['menu'].toSvg()
        }), notificationIcon = computed(() => {
            return feather.icons['bell'].toSvg()
        }), removeNotificationIcon = computed(() => {
            return feather.icons['minus-square'].toSvg()
        }), filteredNotifications = computed(() => {
            return notifications.value.filter(item => !item.has_seen)
        })

        function switchMenu() {
            showMenu.value = !showMenu.value
        }

        function switchNotifications() {
            showNotifications.value = !showNotifications.value
        }

        function clickOutsideNotifications() {
            showNotifications.value = false
        }

        function getNotificationIcon(type) {
            switch (type) {
                case 'friend_request':
                    return feather.icons['user-plus'].toSvg()
                case 'wishlist_expiration':
                    return feather.icons['alert-triangle'].toSvg()
            }
        }

        function seeNotification(id) {
            if (!isLoading.value) {
                axios.post(routes.notifications.see, {
                    id: id
                }).then(() => {
                    let index = notifications.value.findIndex(item => item.id === id)
                    if (index !== -1) {
                        notifications.value[index].has_seen = true
                    }
                    isLoading.value = false
                }).catch(() => {
                    let index = notifications.value.findIndex(item => item.id === id)
                    if (index !== -1) {
                        notifications.value[index].has_seen = true
                    }
                    isLoading.value = false
                })
            }
        }

        return {
            routes,
            translations,
            he,
            filteredNotifications,
            showMenu,
            showNotifications,
            menuIcon,
            notificationIcon,
            removeNotificationIcon,
            switchMenu,
            switchNotifications,
            clickOutsideNotifications,
            getNotificationIcon,
            seeNotification
        }
    }
}
</script>

<style scoped>

.outside {
    width: 100vw;
    height: 100vh;
    position: fixed;
    top: 0;
    left: 0;
    z-index: 0;
}

</style>
