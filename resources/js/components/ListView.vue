<template>
    <div class="flex flex-col items-center shadow-md">
        <a class="w-full" :href="routes.wishlist.show + '/' + defaultWishlist.id">
            <img :src="getPicture" alt="List picture" class="w-full cursor-pointer">
        </a>
        <h2 class="text-2xl md:text-4xl mt-6 mb-6">{{ defaultWishlist.name }}</h2>
        <a class="btn custom-btn-secondary text-center pl-8 pr-8 lg:pl-16 lg:pr-16 pt-3 pb-3" :href="routes.wishlist.edit + '/' + defaultWishlist.id">{{ translations.wishlists.modify }}</a>
        <button v-if="wishlist.status === 'created'" class="btn custom-btn-primary mt-6 mb-6 pl-8 pr-8 lg:pl-16 lg:pr-16 pt-3 pb-3" @click="share">{{ translations.wishlists.publish }}</button>
        <button v-if="wishlist.status === 'published' || wishlist.status === 'expired'" class="disabled:opacity-50 cursor-default custom-btn-primary mt-6 mb-6 pl-8 pr-8 lg:pl-16 lg:pr-16 pt-3 pb-3" disabled>{{ translations.wishlists.publish }}</button>
        <div class="flex justify-between w-full">
            <!-- Sharingbutton Facebook -->
            <a class="resp-sharing-button__link" :href="'https://facebook.com/sharer/sharer.php?u=https%3A%2F%2Fwishu.fr/wishlists/' + defaultWishlist.id"  target="_blank" rel="noopener" aria-label="Facebook">
                <div class="resp-sharing-button resp-sharing-button--facebook resp-sharing-button--medium"><div aria-hidden="true" class="resp-sharing-button__icon resp-sharing-button__icon--circle">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><circle cx="12" cy="12" r="11.5"/><path d="M15.84 9.5H13.5V8.48c0-.53.35-.65.6-.65h1.4v-2.3h-2.35c-2.3 0-2.65 1.7-2.65 2.8V9.5h-2v2h2v7h3v-7h2.1l.24-2z"/></svg></div>Facebook</div>
            </a>

            <!-- Sharingbutton Twitter -->
            <a class="resp-sharing-button__link" :href="'https://twitter.com/intent/tweet/?text=Viens%20découvrir%20ma%20liste%20' + defaultWishlist.name + '&amp;url=https%3A%2F%2Fwishu.fr/wishlists/' + defaultWishlist.id" target="_blank" rel="noopener" aria-label="Twitter">
                <div class="resp-sharing-button resp-sharing-button--twitter resp-sharing-button--medium"><div aria-hidden="true" class="resp-sharing-button__icon resp-sharing-button__icon--circle">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M18.5 7.4l-2 .2c-.4-.5-1-.8-2-.8C13.3 6.8 12 8 12 9.4v.6c-2 0-4-1-5.4-2.7-.2.4-.3.8-.3 1.3 0 1 .4 1.7 1.2 2.2-.5 0-1 0-1.2-.3 0 1.3 1 2.3 2 2.6-.3.4-.7.4-1 0 .2 1.4 1.2 2 2.3 2-1 1-2.5 1.4-4 1 1.3 1 2.7 1.4 4.2 1.4 4.8 0 7.5-4 7.5-7.5v-.4c.5-.4.8-1.5 1.2-2z"/><circle cx="12" cy="12" r="11.5"/></svg></div>Twitter</div>
            </a>
        </div>
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
