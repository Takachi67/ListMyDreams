<template>
    <div class="w-full mt-10 mb-10">
        <div class="w-full h-20 pl-5 pr-5 bg-blue-100 flex justify-between items-center">
            <div class="h-full flex flex-col justify-center">
                <h4 class="text-2xl font-bold">{{ friend.nickname }}</h4>
                <p>{{ friend.email }}</p>
            </div>
            <button @click="removeFriend" class="bg-red-300 flex justify-center items-center text-sm rounded-full p-2">
                <i v-html="trashIcon"></i>
            </button>
        </div>
        <div class="w-full border border-blue-100">
            <div class="flex justify-between items-center h-20 ml-10 mr-10" v-for="wishlist in friend.wishlists">
                <img :src="getPicture(wishlist)" alt="List picture" class="h-16">
                <h2>{{ wishlist.name }}</h2>
                <a :href="routes.wishlist.show + '/' + wishlist.id" class="btn btn-primary">{{ translations.wishlists.open }}</a>
            </div>
        </div>
    </div>
</template>

<script>
import feather from 'feather-icons'
import { computed } from 'vue'
import Swal from "sweetalert2";
import axios from "axios";

export default {
    name: 'Friend',
    props: {
        friend: {
            type: Object,
            default: {}
        }
    },
    setup(props) {
        let translations = window.translations,
            routes = window.routes

        const trashIcon = computed(() => {
            return feather.icons['trash-2'].toSvg()
        })

        function getPicture(wishlist) {
            return '/img/' + wishlist.category + '.jpg'
        }

        function removeFriend() {
            Swal.fire({
                title: translations.friends.remove_question,
                showDenyButton: true,
                showCancelButton: false,
                confirmButtonText: translations.wishlists.create_buttons.yes,
                denyButtonText: translations.wishlists.create_buttons.no
            }).then((result) => {
                if (result.isConfirmed) {
                    axios.post(routes.friends.remove, {
                        friend_id: props.friend.id
                    }).then((response) => {
                        window.location = routes.friends.index
                    }).catch((error) => {
                        Swal.fire({
                            text: error.response.data.message,
                            icon: 'error',
                            confirmButtonText: 'OK'
                        })
                    })
                }
            })
        }

        return {
            translations,
            routes,
            trashIcon,
            getPicture,
            removeFriend
        }
    }
}
</script>

<style scoped>

</style>
