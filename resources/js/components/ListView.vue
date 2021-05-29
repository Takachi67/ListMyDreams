<template>
    <div class="flex flex-col items-center shadow-md">
        <a class="w-full" :href="routes.wishlist.show + '/' + defaultWishlist.id">
            <img :src="getPicture" alt="List picture" class="w-full cursor-pointer">
        </a>
        <h2 class="text-2xl md:text-4xl mt-6 mb-6">{{ defaultWishlist.name }}</h2>
        <a class="btn custom-btn-secondary text-center pl-8 pr-8 lg:pl-16 lg:pr-16 pt-3 pb-3" :href="routes.wishlist.edit + '/' + defaultWishlist.id">{{ translations.wishlists.modify }}</a>
        <button v-if="wishlist.status === 'created'" class="btn custom-btn-primary mt-6 mb-6 pl-8 pr-8 lg:pl-16 lg:pr-16 pt-3 pb-3" @click="share">{{ translations.wishlists.publish }}</button>
        <button v-if="wishlist.status === 'published' || wishlist.status === 'expired'" class="disabled:opacity-50 cursor-default custom-btn-primary mt-6 mb-6 pl-8 pr-8 lg:pl-16 lg:pr-16 pt-3 pb-3" disabled>{{ translations.wishlists.publish }}</button>
    </div>
</template>

<script>
import { computed, ref } from 'vue'
import Wishlist from '../models/Wishlist'
import Swal from 'sweetalert2'
import axios from 'axios'

export default {
    name: 'ListView',
    props: {
        defaultWishlist: {
            type: Wishlist,
            default: new Wishlist()
        },
        friends: {
            type: Array,
            default: []
        }
    },
    setup(props) {
        let wishlist = ref(props.defaultWishlist),
            translations = window.translations,
            routes = window.routes,
            he = window.he

        const getPicture = computed(() => {
            return '/img/' + props.defaultWishlist.category + '.jpg'
        })

        function share() {
            Swal.fire({
                title: translations.wishlists.publish_question.replace(':type:', translations.wishlists.sharing_types[wishlist.value.sharing_type]),
                html: "<b class='text-red-700'>" + translations.wishlists.publish_subquestion + "</b>",
                showDenyButton: true,
                showCancelButton: false,
                confirmButtonText: translations.wishlists.create_buttons.yes,
                denyButtonText: translations.wishlists.create_buttons.no
            }).then((result) => {
                if (result.isConfirmed) {
                    axios.post(routes.wishlist.share, {
                        friends: props.friends.filter(item => item.is_selected),
                        id: wishlist.value.id,
                        type: wishlist.value.sharing_type
                    }).then((response) => {
                        wishlist.value = new Wishlist(response.data.wishlist)
                        Swal.fire({
                            text: response.data.message,
                            icon: 'success',
                            confirmButtonText: 'OK'
                        })
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
            wishlist,
            translations,
            routes,
            he,
            getPicture,
            share
        }
    }
}
</script>

<style scoped>

</style>
