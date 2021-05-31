<template>
    <nav class="hidden md:block w-full h-20 bg-white">
        <div class="ml-24 mr-24 h-full flex justify-between items-center">
            <a class="h-3/4" :href="routes.home">
                <img src="/img/logo.png" alt="Logo" class="h-full">
            </a>
            <div class="h-full flex items-center">
                <a class="flex items-center pl-14 pr-14 h-full hover:bg-blue-50" v-if="user" :href="routes.wishlist.index">{{ translations.buttons.myLists }}</a>
                <a class="flex items-center pl-14 pr-14 h-full hover:bg-blue-50" v-if="user" :href="routes.friends.index">{{ translations.buttons.myFriends }}</a>
                <a class="flex items-center pl-14 pr-14 h-full hover:bg-blue-50" v-if="user" :href="routes.reservations.index">{{ translations.buttons.myReservations }}</a>
            </div>
            <div class="flex items-center">
                <button v-if="user" class="mr-16 relative focus:outline-none" @click="switchQuestions">
                    <i v-html="questionIcon"></i>
                    <span class="absolute rounded-full bg-secondary text-white pastille">{{ filteredQuestions.length }}</span>
                </button>
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
        <ul class="z-10 absolute top-20 right-0 w-full max-h-52 md:w-1/4 border-blue-100 border-t border-b" v-show="showQuestions">
            <li v-if="filteredQuestions.length === 0" class="w-full h-full h-10 bg-white border-blue-100 border">
                <span class="block w-full h-full p-5">{{ he.decode(translations.questions.none) }}</span>
            </li>
            <li v-for="question in filteredQuestions" class="w-full h-full bg-white border-blue-100 border">
                <div v-if="question.type === 'question'" class="grid grid-cols-10 flex justify-between items-center cursor-pointer" @click="showInput(question)">
                    <span class="hover:bg-blue-50 col-span-10 h-full flex items-center p-5"><i class="mr-3" v-html="getQuestionIcon(question.type)"></i> <span class="mt-0.5" v-html="he.decode(translations.questions.new_question.replace(':name:', '<b>' + question.alias + '</b>'))"></span></span>
                </div>
                <div v-else class="grid grid-cols-10 flex justify-between items-center">
                    <div class="hover:bg-blue-50 col-span-8 h-full items-center p-5">
                        <a :href="routes.wishlist.show + '/' + question.wishlist.id" class="flex items-center mb-3">{{ he.decode(translations.questions.answer_received.replace(':user:', question.user.nickname)) }} ( {{ question.wishlist.name }} )</a>
                        <p><span class="font-bold">{{ translations.questions.question }}:</span> {{ question.question.message }}</p>
                        <p><span class="font-bold">{{ translations.questions.answer }}:</span> {{ question.message }}</p>
                    </div>
                    <button @click="removeAnswer(question)" class="hover:bg-secondary hover:text-white col-span-2 flex justify-center items-center h-full w-full">
                        <i v-html="removeNotificationIcon"></i>
                    </button>
                </div>
                <div v-show="question.show_input" class="block m-3"><span class="font-bold">{{ translations.questions.question }}:</span> {{ question.message }}</div>
                <div v-show="question.show_input" class="grid grid-cols-10 flex justify-between items-center">
                    <span class="hover:bg-blue-50 col-span-8 h-full flex items-center p-3">
                        <input type="text" v-on:keyup.enter="answer(question)" v-model="question.answer" :placeholder="translations.questions.answer" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                    </span>
                    <button @click="answer(question)" class="col-span-2 btn btn-primary flex justify-center"><i v-html="answerIcon"></i></button>
                </div>
            </li>
        </ul>
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
                <button v-if="user" class="bell-mobile mr-10 relative focus:outline-none" @click="switchQuestions">
                    <i v-html="questionIcon"></i>
                    <span class="absolute rounded-full bg-secondary text-white pastille-mobile text-sm">{{ filteredQuestions.length }}</span>
                </button>
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
                <a class="block w-full h-full p-5" :href="routes.reservations.index">{{ translations.buttons.myReservations }}</a>
            </li>
            <li class="w-full h-full h-10 bg-white border-blue-100 border" v-if="user">
                <a class="block w-full h-full p-5" :href="routes.users.profile">{{ translations.buttons.myProfile }}</a>
            </li>
            <li class="w-full h-full h-10 bg-white border-blue-100 border" v-else>
                <a class="block w-full h-full p-5" :href="routes.login">{{ translations.auth.login }}</a>
            </li>
        </ul>
        <ul class="z-10 absolute top-14 right-0 w-full max-h-52 md:w-1/4 border-blue-100 border-t border-b" v-show="showQuestions">
            <li v-if="filteredQuestions.length === 0" class="w-full h-full h-10 bg-white border-blue-100 border">
                <span class="block w-full h-full p-5">{{ he.decode(translations.questions.none) }}</span>
            </li>
            <li v-for="question in filteredQuestions" class="w-full h-full bg-white border-blue-100 border">
                <div v-if="question.type === 'question'" class="grid grid-cols-10 flex justify-between items-center cursor-pointer" @click="showInput(question)">
                    <span class="hover:bg-blue-50 col-span-10 h-full flex items-center p-5"><i class="mr-3" v-html="getQuestionIcon(question.type)"></i> <span class="mt-0.5" v-html="he.decode(translations.questions.new_question.replace(':name:', '<b>' + question.alias + '</b>'))"></span></span>
                </div>
                <div v-else class="grid grid-cols-10 flex justify-between items-center">
                    <div class="hover:bg-blue-50 col-span-8 h-full items-center p-5">
                        <a :href="routes.wishlist.show + '/' + question.wishlist.id" class="flex items-center mb-3">{{ he.decode(translations.questions.answer_received.replace(':user:', question.user.nickname)) }} ( {{ question.wishlist.name }} )</a>
                        <p><span class="font-bold">{{ translations.questions.question }}:</span> {{ question.question.message }}</p>
                        <p><span class="font-bold">{{ translations.questions.answer }}:</span> {{ question.message }}</p>
                    </div>
                    <button @click="removeAnswer(question)" class="hover:bg-secondary hover:text-white col-span-2 flex justify-center items-center h-full w-full">
                        <i v-html="removeNotificationIcon"></i>
                    </button>
                </div>
                <div v-show="question.show_input" class="block m-3"><span class="font-bold">{{ translations.questions.question }}:</span> {{ question.message }}</div>
                <div v-show="question.show_input" class="grid grid-cols-10 flex justify-between items-center">
                    <span class="hover:bg-blue-50 col-span-8 h-full flex items-center p-3">
                        <input type="text" v-on:keyup.enter="answer(question)" v-model="question.answer" :placeholder="translations.questions.answer" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                    </span>
                    <button @click="answer(question)" class="col-span-2 btn btn-primary flex justify-center"><i v-html="answerIcon"></i></button>
                </div>
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
    <div v-if="showNotifications || showQuestions" class="outside" v-on:click="clickOutsideNotifications"></div>
</template>

<script>
import { computed, ref } from 'vue'
import feather from 'feather-icons'
import axios from 'axios'
import Swal from "sweetalert2";

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
        },
        defaultQuestions: {
            type: Array,
            default: []
        }
    },
    setup(props) {
        let routes = window.routes,
            translations = window.translations,
            he = window.he,
            notifications = ref(props.defaultNotifications),
            questions = ref(props.defaultQuestions),
            showMenu = ref(false),
            showNotifications = ref(false),
            showQuestions = ref(false),
            isLoading = ref(false)

        const menuIcon = computed(() => {
            return feather.icons['menu'].toSvg()
        }), notificationIcon = computed(() => {
            return feather.icons['bell'].toSvg()
        }), questionIcon = computed(() => {
            return feather.icons['mail'].toSvg()
        }), removeNotificationIcon = computed(() => {
            return feather.icons['minus-square'].toSvg()
        }), answerIcon = computed(() => {
            return feather.icons['send'].toSvg()
        }), filteredNotifications = computed(() => {
            return notifications.value.filter(item => !item.has_seen)
        }), filteredQuestions = computed(() => {
            return questions.value.filter(item => !item.has_answered)
        })

        function switchMenu() {
            showMenu.value = !showMenu.value
        }

        function switchNotifications() {
            showNotifications.value = !showNotifications.value
        }

        function switchQuestions() {
            showQuestions.value = !showQuestions.value
        }

        function clickOutsideNotifications() {
            showNotifications.value = false
            showQuestions.value = false
        }

        function getNotificationIcon(type) {
            switch (type) {
                case 'friend_request':
                    return feather.icons['user-plus'].toSvg()
                case 'wishlist_expiration':
                    return feather.icons['alert-triangle'].toSvg()
            }
        }

        function getQuestionIcon(type) {
            switch (type) {
                case 'question':
                    return feather.icons['help-circle'].toSvg()
                case 'answer':
                    return feather.icons['info'].toSvg()
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

        function showInput(question) {
            question.show_input = !question.show_input
        }

        function answer(question) {
            axios.post(routes.questions.answer, {
                question_id: question.id,
                message: question.answer
            }).then(() => {
                let index = questions.value.findIndex(item => item.id === question.id)

                if (index !== -1) {
                    questions.value.splice(index, 1)
                }

                Swal.fire({
                    title: translations.items.success,
                    text: translations.questions.answer_saved,
                    icon: 'success',
                    confirmButtonText: 'OK'
                })
            })
        }

        function removeAnswer(question) {
            axios.post(routes.questions.showAnswer, {
                question_id: question.id
            }).then(() => {
                let index = questions.value.findIndex(item => item.id === question.id)

                if (index !== -1)
                    questions.value.splice(index, 1)
            })
        }

        return {
            routes,
            translations,
            he,
            filteredNotifications,
            filteredQuestions,
            showMenu,
            showNotifications,
            showQuestions,
            menuIcon,
            notificationIcon,
            questionIcon,
            removeNotificationIcon,
            answerIcon,
            switchMenu,
            switchNotifications,
            switchQuestions,
            clickOutsideNotifications,
            getNotificationIcon,
            getQuestionIcon,
            seeNotification,
            showInput,
            answer,
            removeAnswer
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
