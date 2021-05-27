<template>
    <div>
        <div class="grid grid-cols-2" v-if="showPassword || message">
            <div class="flex flex-col mt-3 w-11/12">
                <label class="text-xl">{{ translations.user.password }}</label>
                <input type="password" name="password" :placeholder="translations.user.password" class="col-span-2 rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                <small class="text-red-700">{{ message }}</small>
            </div>
            <div class="flex flex-col mt-3 w-11/12 ml-auto">
                <label class="text-xl">{{ translations.user.password_confirmation }}</label>
                <input type="password" name="password_confirmation" :placeholder="translations.user.password_confirmation" class="col-span-2 rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
            </div>
        </div>
        <div class="w-full flex justify-between mt-10">
            <div class="btn btn-primary cursor-pointer" v-if="!showPassword && !message" @click="open">{{ translations.user.update_password }}</div>
            <div class="btn btn-primary cursor-pointer" v-if="showPassword || message" @click="close">{{ translations.user.cancel_password }}</div>
            <button class="btn btn-primary" type="submit">{{ translations.user.save }}</button>
        </div>
    </div>
</template>

<script>
import { ref } from 'vue'

export default {
    name: 'Password',
    props: {
        error: {
            type: String,
            default: ''
        }
    },
    setup(props) {
        let showPassword = ref(false),
            translations = window.translations,
            message = ref(props.error)

        function open() {
            showPassword.value = true
        }

        function close() {
            showPassword.value = false
            message.value = ''
        }

        return {
            showPassword,
            translations,
            message,
            open,
            close
        }
    }
}
</script>

<style scoped>

</style>
