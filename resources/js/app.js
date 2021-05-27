import { createApp } from 'vue'
import Navigation from './components/Navigation.vue'
import EditWishlist from './components/EditWishlist.vue'
import Wishlist from './components/Wishlist.vue'
import ListView from './components/ListView.vue'
import Friend from './components/Friend.vue'
import Requests from './components/Requests.vue'
import Messenger from './components/Messenger.vue'
import Password from './components/Password.vue'

// @ts-ignore
window.he = require('he')

window.onload = () => {
    let app = createApp({})
    app.component('Navigation', Navigation)
    app.component('EditWishlist', EditWishlist)
    app.component('Wishlist', Wishlist)
    app.component('ListView', ListView)
    app.component('Friend', Friend)
    app.component('Requests', Requests)
    app.component('Messenger', Messenger)
    app.component('Password', Password)
    app.mount('#main')

    const feather = require('feather-icons')
    feather.replace()
}
