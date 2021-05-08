import { createApp } from 'vue'
import Navigation from './components/Navigation.vue'
import Wishlist from './components/Wishlist.vue'

// @ts-ignore
window.he = require('he')

window.onload = () => {
    let app = createApp({})
    app.component('Navigation', Navigation)
    app.component('Wishlist', Wishlist)
    app.mount('#main')

    const feather = require('feather-icons')
    feather.replace()
}
