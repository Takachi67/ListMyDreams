<template>
    <div class="w-full mt-10 mb-10">
        <div class="w-full h-20 pl-5 pr-5 bg-blue-100 flex justify-between items-center">
            <div class="h-full flex flex-col justify-center">
                <h4 class="text-2xl font-bold">{{ he.decode(translations.friends.requests) }}</h4>
            </div>
        </div>
        <div class="w-full border border-blue-100">
            <h2 class="text-2xl md:text-3xl font-bold ml-3 md:ml-10 mt-3 md:mt-10 mb-3">{{ translations.friends.pending_requests }}</h2>
            <div class="flex justify-between items-center ml-10 mr-10 mb-10 hover:bg-gray-50" v-for="request in requests">
                <h4 class="text-2xl">{{ request.sender.nickname }}</h4>
                <div class="flex">
                    <button class="btn btn-primary mr-2" @click="accept(request)">{{ translations.friends.accept }}</button>
                    <button class="btn btn-secondary" @click="decline(request)">{{ translations.friends.decline }}</button>
                </div>
            </div>
            <div class="m-3 md:m-10">
                <h2 class="text-xl md:text-3xl font-bold">{{ translations.friends.new_request }}</h2>
                <div class="mt-3">
                    <label for="email" class="text-xl">{{ translations.user.email }} <span class="text-red-400">*</span></label>
                    <div class="grid grid-cols-10">
                        <input type="text" v-on:keyup.enter="send" v-model="email" class="col-span-7 md:col-span-9 rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50" id="email" :placeholder="translations.user.email">
                        <button class="col-span-3 md:col-span-1 btn btn-primary ml-auto" @click="send">{{ translations.friends.send }}</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import feather from 'feather-icons'
import { computed, ref } from 'vue'
import Swal from 'sweetalert2'
import axios from 'axios'

export default {
    name: 'Requests',
    props: {
        defaultRequests: {
            type: Array,
            default: []
        }
    },
    setup(props) {
        let translations = window.translations,
            routes = window.routes,
            he = window.he,
            email = ref(''),
            requests = ref(props.defaultRequests)

        function send() {
            axios.post(routes.friends.request, {
                email: email.value
            }).then((response) => {
                Swal.fire({
                    text: response.data.message,
                    icon: 'success',
                    confirmButtonText: 'OK'
                })
                email.value = ''
            }).catch((error) => {
                Swal.fire({
                    text: error.response.data.message,
                    icon: 'error',
                    confirmButtonText: 'OK'
                })
            })
        }

        function accept(request) {
            axios.post(routes.friends.accept, request).then((response) => {
                Swal.fire({
                    text: response.data.message,
                    icon: 'success',
                    confirmButtonText: 'OK'
                })
                requests.value = requests.value.filter(item => item.id !== request.id)
            }).catch((error) => {
                Swal.fire({
                    text: error.response.data.message,
                    icon: 'error',
                    confirmButtonText: 'OK'
                })
            })
        }

        function decline(request) {
            axios.post(routes.friends.decline, request).then((response) => {
                Swal.fire({
                    text: response.data.message,
                    icon: 'success',
                    confirmButtonText: 'OK'
                })
                requests.value = requests.value.filter(item => item.id !== request.id)
            }).catch((error) => {
                Swal.fire({
                    text: error.response.data.message,
                    icon: 'error',
                    confirmButtonText: 'OK'
                })
            })
        }

        return {
            translations,
            email,
            requests,
            he,
            send,
            accept,
            decline
        }
    }
}
</script>

<style scoped>

</style>
