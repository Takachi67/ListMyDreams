<template>
    <div class="flex flex-col items-center shadow-md">
        <img :src="getPicture" alt="List picture" class="w-full cursor-pointer">
        <h2 class="text-2xl md:text-4xl mt-6 mb-6">{{ defaultWishlist.name }}</h2>
        <button class="btn custom-btn-secondary pl-16 pr-16 pt-3 pb-3">{{ translations.wishlists.modify }}</button>
        <button class="btn custom-btn-primary mt-6 mb-6 pl-16 pr-16 pt-3 pb-3">{{ translations.wishlists.share }}</button>
    </div>
</template>

<script>
import { computed } from 'vue'
import Wishlist from '../models/Wishlist'

export default {
    name: 'ListView',
    props: {
        defaultWishlist: {
            type: Wishlist,
            default: new Wishlist()
        }
    },
    setup(props) {
        let translations = window.translations

        const getPicture = computed(() => {
            return '/img/' + props.defaultWishlist.category + '.jpg'
        })

        return {
            translations,
            getPicture
        }
    }
}
</script>

<style scoped>

</style>
