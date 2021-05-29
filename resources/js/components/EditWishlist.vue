<template>
    <transition name="modal">
        <div class="modal-mask" @click="closeModal" v-show="showModal">
            <div class="modal-wrapper">
                <div class="modal-container md:w-1/2" @click.stop>
                    <div class="modal-header">
                        <slot name="header">
                            <h4 class="text-3xl">{{ openedItem.name }}</h4>
                        </slot>
                    </div>
                    <div class="modal-body">
                        <slot name="body">
                            <p class="break-all text-xl"><b>{{ translations.items.link }}</b>: <a class="text-blue-600 underline" target="_blank" :href="openedItem.link">{{ openedItem.link }}</a></p>
                            <p class="text-xl"><b>{{ translations.items.priority }}</b>: {{ he.decode(translations.items.priorities[openedItem.priority]) }}</p>
                            <p class="text-xl" v-if="openedItem.comment"><b>{{ translations.items.comment }}</b>: {{ openedItem.comment }}</p>
                        </slot>
                    </div>
                    <div class="modal-footer">
                        <slot name="footer">
                            <button class="btn btn-primary" @click="closeModal">OK</button>
                        </slot>
                    </div>
                </div>
            </div>
        </div>
    </transition>
    <p class="text-red-700 ml-10 md:ml-20 mt-6 flex items-center" v-if="wishlist.status === 'published'">
        <i v-html="infoIcon"></i>
        <span class="mt-1 ml-3">{{ he.decode(translations.wishlists.published_message) }}</span>
    </p>
    <p class="text-red-700 ml-10 md:ml-20 mt-6 flex items-center" v-if="wishlist.status === 'expired'">
        <i v-html="infoIcon"></i>
        <span class="mt-1 ml-3">{{ he.decode(translations.wishlists.expired_creator_message) }}</span>
    </p>
    <div class="grid grid-cols-1 md:grid-cols-3 mt-6 mb-6 ml-10 mr-10 md:ml-20 md:mr-20 relative">
        <ul :class="['paper w-full', wishlist.status === 'expired' ? 'md:col-span-3' : 'md:col-span-2 md:w-11/12']" :style="{ '--color': wishlist.border_color }">
            <li class="item flex justify-between cursor-pointer" v-for="item in wishlist.items" @click="openModal(item)" :style="{ borderBottom: '1px dotted ' + wishlist.line_color, color: wishlist.text_color }">
                {{ item.name }}
                <button v-on:click.stop @click="removeItem(item)" class="bg-red-300 flex justify-center items-center text-sm rounded-full p-2" v-if="wishlist.status !== 'expired' && (!item.id || (item.id && wishlist.status !== 'published'))">
                    <i v-html="trashIcon"></i>
                </button>
            </li>
            <li v-for="i in [...Array(10 - wishlist.items.length).keys()]" :style="{ borderBottom: '1px dotted ' + wishlist.line_color, color: wishlist.text_color }"></li>
        </ul>
        <div v-if="wishlist.status !== 'expired'">
            <h2 class="mt-6 md:mt-0 text-4xl">{{ translations.items.newItem }}</h2>
            <div class="mt-6 flex items-center">
                <label for="name" class="w-1/3 text-xl">{{ translations.items.name }} <span class="text-red-400">*</span></label>
                <input type="text" v-model="newItem.name" class="col-span-2 w-2/3 rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50" id="name" :placeholder="translations.items.name">
            </div>
            <div class="mt-6 flex items-center">
                <label for="link" class="w-1/3 text-xl">{{ translations.items.link }} <span class="text-red-400">*</span></label>
                <input type="text" v-model="newItem.link" class="col-span-2 w-2/3 rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50" id="link" :placeholder="translations.items.link">
            </div>
            <div class="mt-6 flex items-center">
                <label for="priority" class="w-1/3 text-xl">{{ translations.items.priority }} <span class="text-red-400">*</span></label>
                <select name="priority" v-model="newItem.priority" id="priority" class="col-span-2 w-2/3 rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                    <option v-for="(value, key) in translations.items.priorities" :value="key">{{ he.decode(value) }}</option>
                </select>
            </div>
            <div class="mt-6 flex items-center">
                <label for="comment" class="w-1/3 text-xl">{{ translations.items.comment }}</label>
                <textarea name="comment" v-model="newItem.comment" id="comment" class="max-h-36 col-span-2 w-2/3 rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50" :placeholder="translations.items.comment"></textarea>
            </div>
            <button class="btn-primary float-right mt-6" @click="addItem">{{ translations.items.add }}</button>
        </div>
        <div v-else>

        </div>
    </div>
    <div class="ml-10 md:ml-20 mr-10 md:mr-20" v-if="wishlist.status !== 'expired'">
        <h2 class="text-4xl">{{ translations.items.customization }}</h2>
        <div class="grid md:grid-cols-4">
            <div class="flex flex-col mt-3">
                <label for="wishlist_name" class="text-xl">{{ translations.wishlists.name }} <span class="text-red-400">*</span></label>
                <input type="text" v-model="wishlist.name" class="md:w-11/12 col-span-2 rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50" id="wishlist_name" :placeholder="translations.wishlists.name">
            </div>
            <div class="flex flex-col mt-3">
                <label for="category" class="text-xl">{{ translations.wishlists.category }} <span class="text-red-400">*</span></label>
                <select v-model="wishlist.category" class="md:w-11/12 col-span-2 rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50" id="category">
                    <option v-for="(value, key) in translations.wishlists.categories" :value="key">{{ he.decode(value) }}</option>
                </select>
            </div>
            <div class="flex flex-col mt-3">
                <label for="sharing_type" class="text-xl">{{ translations.wishlists.sharing_type }} <span class="text-red-400">*</span></label>
                <select v-model="wishlist.sharing_type" class="md:w-11/12 col-span-2 rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50" id="sharing_type">
                    <option v-for="(value, key) in translations.wishlists.sharing_types" :value="key">{{ he.decode(value) }}</option>
                </select>
            </div>
            <div class="flex flex-col mt-3">
                <label for="expiration_date" class="text-xl">{{ he.decode(translations.wishlists.expiration_date) }}</label>
                <input type="datetime-local" v-model="wishlist.expire_at" class="md:w-11/12 col-span-2 rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50" id="expiration_date" :placeholder="translations.wishlists.expiration_date">
            </div>
        </div>
        <div class="flex justify-between w-full mt-5">
            <div class="flex flex-col items-center">
                <label class="text-xl md:text-2xl">{{ translations.items.border_color }}</label>
                <div @click="openPicker('border-picker')" class="w-10 h-10 md:w-32 md:h-32 rounded-full flex justify-center items-center" :style="{ backgroundColor: wishlist.border_color }">
                    <input type="color" id="border-picker" class="invisible" v-model="wishlist.border_color">
                </div>
            </div>
            <div class="flex flex-col items-center">
                <label class="text-xl md:text-2xl">{{ translations.items.text_color }}</label>
                <div @click="openPicker('text-picker')" class="w-10 h-10 md:w-32 md:h-32 rounded-full flex justify-center items-center" :style="{ backgroundColor: wishlist.text_color }">
                    <input type="color" id="text-picker" class="invisible" v-model="wishlist.text_color">
                </div>
            </div>
            <div class="flex flex-col items-center">
                <label class="text-xl md:text-2xl">{{ translations.items.line_color }}</label>
                <div @click="openPicker('line-picker')" class="w-10 h-10 md:w-32 md:h-32 rounded-full flex justify-center items-center" :style="{ backgroundColor: wishlist.line_color }">
                    <input type="color" id="line-picker" class="invisible" v-model="wishlist.line_color">
                </div>
            </div>
        </div>
    </div>
    <div class="w-full flex justify-center mt-10 mb-10" v-if="wishlist.status !== 'expired'">
        <button v-if="wishlist.id" class="btn btn-primary" @click="update">{{ translations.wishlists.update_list }}</button>
        <button v-else class="btn btn-primary" @click="create">{{ translations.wishlists.create_list }}</button>
    </div>
    <div class="w-full flex justify-center mt-10 mb-10" v-else>
        <button class="btn btn-primary" @click="duplicate">{{ translations.wishlists.duplicate_list }}</button>
    </div>
</template>

<script>
import {computed, ref} from 'vue'
import Item from '../models/Item'
import Wishlist from '../models/Wishlist'
import Swal from 'sweetalert2'
import axios from 'axios'
import feather from 'feather-icons'

export default {
    name: 'EditWishlist',
    props: {
        defaultWishlist: {
            type: Wishlist,
            default: new Wishlist()
        }
    },
    setup(props) {
        let wishlist = ref(props.defaultWishlist),
            translations = window.translations,
            routes = window.routes,
            he = window.he,
            newItem = ref(new Item({
                temp_id: Math.floor(Math.random() * -1000000)
            })),
            showModal = ref(false),
            openedItem = ref(new Item())

        const trashIcon = computed(() => {
            return feather.icons['trash-2'].toSvg()
        }), infoIcon = computed(() => {
            return feather.icons['info'].toSvg()
        })

        function addItem() {
            if (!newItem.value.name || !newItem.value.link || !newItem.value.priority) {
                Swal.fire({
                    title: translations.items.error,
                    text: he.decode(translations.items.missing_properties),
                    icon: 'error',
                    confirmButtonText: 'OK'
                })
            } else {
                wishlist.value.items.push(newItem.value)
                newItem.value = new Item({
                    temp_id: Math.floor(Math.random() * -1000000)
                })
            }
        }

        function openModal(item) {
            openedItem.value = item
            showModal.value = true
        }

        function closeModal() {
            openedItem.value = new Item()
            showModal.value = false
        }

        function openPicker(id) {
            document.getElementById(id).click()
        }

        function create() {
            Swal.fire({
                title: translations.wishlists.create_question,
                showDenyButton: true,
                showCancelButton: false,
                confirmButtonText: translations.wishlists.create_buttons.yes,
                denyButtonText: translations.wishlists.create_buttons.no
            }).then((result) => {
                if (result.isConfirmed) {
                    axios.post(routes.wishlist.store, wishlist.value).then((response) => {
                        window.location = routes.wishlist.index
                    }).catch((error) => {
                        let message

                        if (error.response.status === 422) {
                            message = Object.values(error.response.data.errors)[0][0]
                        } else {
                            message = error.response.data.message
                        }

                        Swal.fire({
                            text: message,
                            icon: 'error',
                            confirmButtonText: 'OK'
                        })
                    })
                }
            })
        }

        function update() {
            Swal.fire({
                title: translations.wishlists.update_question,
                showDenyButton: true,
                showCancelButton: false,
                confirmButtonText: translations.wishlists.create_buttons.yes,
                denyButtonText: translations.wishlists.create_buttons.no
            }).then((result) => {
                if (result.isConfirmed) {
                    axios.post(routes.wishlist.update, wishlist.value).then((response) => {
                        window.location = routes.wishlist.index
                    }).catch((error) => {
                        let message

                        if (error.response.status === 422) {
                            message = Object.values(error.response.data.errors)[0][0]
                        } else {
                            message = error.response.data.message
                        }

                        Swal.fire({
                            text: message,
                            icon: 'error',
                            confirmButtonText: 'OK'
                        })
                    })
                }
            })
        }

        function duplicate() {
            Swal.fire({
                title: translations.wishlists.duplicate_question,
                showDenyButton: true,
                showCancelButton: false,
                confirmButtonText: translations.wishlists.create_buttons.yes,
                denyButtonText: translations.wishlists.create_buttons.no
            }).then((result) => {
                if (result.isConfirmed) {
                    axios.get(routes.wishlist.duplicate + '/' + wishlist.value.id).then((response) => {
                        window.location = routes.wishlist.edit + '/' + response.data.id
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

        function removeItem(item) {
            let index

            if (item.id)
                index = wishlist.value.items.findIndex(data => data.id === item.id)
            else
                index = wishlist.value.items.findIndex(data => data.temp_id === item.temp_id)

            if (index !== -1)
                wishlist.value.items.splice(index, 1)
        }

        return {
            wishlist,
            translations,
            he,
            newItem,
            showModal,
            openedItem,
            trashIcon,
            infoIcon,
            addItem,
            openModal,
            closeModal,
            openPicker,
            create,
            update,
            duplicate,
            removeItem
        }
    }
}
</script>

<style scoped>

.paper {
    position: relative;
    border: 1px solid #dedede;
    color: #555;
    font-size: 20px;
    padding: 0;
    min-height: 500px;
    background-image: url('/img/paper.png');
    background-position: initial;
    background-repeat: initial;
    box-shadow: 0 0 5px rgba(0,0,0,0.2), inset 0 0 50px rgba(0,0,0,0.1);
}
.paper li {
    list-style: none;
    padding: 10px 10px 10px 55px;
    height: 50px;
    position: relative;
    text-transform: capitalize;
    transition: all 0.3s ease-in-out;
}
.paper:before {
    border-left: 3px double var(--color);
    content: '';
    height: 100%;
    left: 35px;
    position: absolute;
}
.paper:after {
    left: auto;
    right: 12px;
}
.paper .item:hover {
    background-color: rgba(255,255,255,0.3);
}

</style>
