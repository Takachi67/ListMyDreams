<template>
    <div class="mt-6 mb-6 ml-10 mr-10 md:ml-20 md:mr-20 relative">
        <h2 class="text-4xl font-bold">{{ translations.messenger.discussion }}</h2>
        <div class="w-full h-80 overflow-y-auto bg-gray-200 border border-black">
            <div v-for="message in reversedMessages">
                <div class="flex flex-col items-end m-4" v-if="message.user.id === user.id">
                    <span class="font-bold">{{ message.user.nickname }}</span>
                    <div class="p-2 border border-blue-700 bg-blue-50 rounded-l-full rounded-tr-full">{{ message.message }}</div>
                    <small class="mt-1">{{ message.date }}</small>
                </div>
                <div class="w-full flex flex-col items-start m-4" v-else>
                    <span class="font-bold">{{ message.user.nickname }}</span>
                    <div class="p-2 border border-gray-700 bg-gray-50 rounded-r-full rounded-tl-full">{{ message.message }}</div>
                    <small class="mt-1">{{ message.date }}</small>
                </div>
            </div>
        </div>
        <div class="grid grid-cols-10 mt-3">
            <input type="text" v-on:keyup.enter="send" v-model="message" :placeholder="translations.messenger.your_message" class="col-span-9 rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
            <button class="btn btn-primary" @click="send">{{ translations.messenger.send }}</button>
        </div>
    </div>
</template>

<script>
import { computed, ref } from 'vue'
import axios from 'axios'
import moment from 'moment'
import Swal from 'sweetalert2'

export default {
    name: 'Messenger',
    props: {
        defaultMessages: {
            type: Array,
            default: []
        },
        user: {
            type: Object,
            default: {}
        },
        list: {
            type: Object,
            default: {}
        }
    },
    setup(props) {
        let translations = window.translations,
            routes = window.routes,
            messages = ref(props.defaultMessages),
            message = ref('')

        const reversedMessages = computed(() => {
            return messages.value.sort((a, b) => {
                return new Date(b.created_at) - new Date(a.created_at)
            }).map((item) => {
                item.date = moment(item.created_at).format('DD/MM/YYYY HH:mm')
                return item
            })
        })

        function send() {
            if (message.value.length > 0) {
                axios.post(routes.messenger.send, {
                    list_id: props.list.id,
                    message: message.value
                }).then((response) => {
                    messages.value.push(response.data.message)
                    message.value = ''
                }).catch((error) => {
                    Swal.fire({
                        text: error.response.data.message,
                        icon: 'error',
                        confirmButtonText: 'OK'
                    })
                })
            }
        }

        return {
            translations,
            messages,
            reversedMessages,
            message,
            send
        }
    }
}
</script>

<style scoped>

</style>
