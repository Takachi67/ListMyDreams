<template>
    <transition name="modal">
        <div class="modal-mask" @click="closeModal" v-show="showModal">
            <div class="modal-wrapper">
                <div class="modal-container" @click.stop>
                    <div class="modal-header">
                        <slot name="header">
                            <h4 class="text-3xl">{{ openedItem.name }}</h4>
                        </slot>
                    </div>
                    <div class="modal-body">
                        <slot name="body">
                            <p>{{ translations.items.link }}: {{ openedItem.link }}</p>
                            <p>{{ translations.items.priority }}: {{ he.decode(translations.items.priorities[openedItem.priority]) }}</p>
                            <p>{{ translations.items.comment }}: {{ openedItem.comment }}</p>
                        </slot>
                    </div>
                    <div class="modal-footer">
                        <slot name="footer">
                            <button class="btn btn-primary" @click="closeModal">
                                OK
                            </button>
                        </slot>
                    </div>
                </div>
            </div>
        </div>
    </transition>
    <div class="grid md:grid-cols-3 mt-6 mb-6 ml-20 mr-20 relative">
        <ul class="paper md:col-span-2" :style="{ '--color': wishlist.border_color }">
            <li v-for="item in wishlist.items" @click="openModal(item)" :style="{ borderBottom: '1px dotted ' + wishlist.line_color, color: wishlist.text_color }">
                {{ item.name }}
            </li>
            <li v-for="i in [...Array(10 - wishlist.items.length).keys()]" :style="{ borderBottom: '1px dotted ' + wishlist.line_color, color: wishlist.text_color }"></li>
        </ul>
        <div>
            <h2 class="text-4xl">{{ translations.items.newItem }}</h2>
            <div class="mt-6 flex items-center">
                <label for="name" class="w-1/3 text-xl">{{ translations.items.name }}</label>
                <input type="text" v-model="newItem.name" class="col-span-2 w-2/3 rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50" id="name" :placeholder="translations.items.name">
            </div>
            <div class="mt-6 flex items-center">
                <label for="link" class="w-1/3 text-xl">{{ translations.items.link }}</label>
                <input type="text" v-model="newItem.link" class="col-span-2 w-2/3 rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50" id="link" :placeholder="translations.items.link">
            </div>
            <div class="mt-6 flex items-center">
                <label for="priority" class="w-1/3 text-xl">{{ translations.items.priority }}</label>
                <select name="priority" v-model="newItem.priority" id="priority" class="col-span-2 w-2/3 rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                    <option value="low">{{ translations.items.priorities.low }}</option>
                    <option value="medium">{{ translations.items.priorities.medium }}</option>
                    <option value="high">{{ translations.items.priorities.high }}</option>
                    <option value="ultra">{{ he.decode(translations.items.priorities.ultra) }}</option>
                </select>
            </div>
            <div class="mt-6 flex items-center">
                <label for="comment" class="w-1/3 text-xl">{{ translations.items.comment }}</label>
                <textarea name="comment" v-model="newItem.comment" id="comment" class="max-h-36 col-span-2 w-2/3 rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50" :placeholder="translations.items.comment"></textarea>
            </div>
            <button class="btn-primary float-right mt-6" @click="addItem">{{ translations.items.add }}</button>
        </div>
    </div>
    <div class="ml-20 mr-20">
        <h2 class="text-4xl">{{ translations.items.customization }}</h2>
        <div class="flex justify-between w-full mt-5">
            <div class="flex flex-col items-center">
                <label class="text-2xl">{{ translations.items.border_color }}</label>
                <div @click="openPicker('border-picker')" class="w-32 h-32 rounded-full flex justify-center items-center" :style="{ backgroundColor: wishlist.border_color }">
                    <input type="color" id="border-picker" class="invisible" v-model="wishlist.border_color">
                </div>
            </div>
            <div class="flex flex-col items-center">
                <label class="text-2xl">{{ translations.items.text_color }}</label>
                <div @click="openPicker('text-picker')" class="w-32 h-32 rounded-full flex justify-center items-center" :style="{ backgroundColor: wishlist.text_color }">
                    <input type="color" id="text-picker" class="invisible" v-model="wishlist.text_color">
                </div>
            </div>
            <div class="flex flex-col items-center">
                <label class="text-2xl">{{ translations.items.line_color }}</label>
                <div @click="openPicker('line-picker')" class="w-32 h-32 rounded-full flex justify-center items-center" :style="{ backgroundColor: wishlist.line_color }">
                    <input type="color" id="line-picker" class="invisible" v-model="wishlist.line_color">
                </div>
            </div>
        </div>
    </div>
    <div class="w-full flex justify-center mt-20 mb-10">
        <button class="btn btn-primary">{{ translations.items.create_list }}</button>
    </div>
</template>

<script>
import { ref } from 'vue'
import Item from '../models/Item'
import Wishlist from '../models/Wishlist'
import Swal from 'sweetalert2'

export default {
    name: 'Wishlist',
    props: {
        defaultWishlist: {
            type: Wishlist,
            default: new Wishlist()
        }
    },
    setup(props) {
        let wishlist = ref(props.defaultWishlist),
            translations = window.translations,
            he = window.he,
            newItem = ref(new Item()),
            showModal = ref(false),
            openedItem = ref(new Item())

        function addItem() {
            if (!newItem.value.name || !newItem.value.link || !newItem.value.priority || !newItem.value.comment) {
                Swal.fire({
                    title: translations.items.error,
                    text: he.decode(translations.items.missing_properties),
                    icon: 'error',
                    confirmButtonText: 'OK'
                })
            } else {
                wishlist.value.items.push(newItem.value)
                newItem.value = new Item()
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

        return {
            wishlist,
            translations,
            he,
            newItem,
            showModal,
            openedItem,
            addItem,
            openModal,
            closeModal,
            openPicker
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
    width: 96%;
    min-height: 500px;
    background-image: url('/img/paper.png');
    background-position: initial;
    background-repeat: initial;
    box-shadow: 0 0 5px rgba(0,0,0,0.2), inset 0 0 50px rgba(0,0,0,0.1);
}
.paper li {
    cursor: pointer;
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
.paper li:hover {
    background-color: rgba(255,255,255,0.3);
}

.modal-mask {
    position: fixed;
    z-index: 9998;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    display: table;
    transition: opacity 0.3s ease;
}

.modal-wrapper {
    display: table-cell;
    vertical-align: middle;
}

.modal-container {
    width: 300px;
    margin: 0px auto;
    padding: 20px 30px;
    background-color: #fff;
    border-radius: 2px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.33);
    transition: all 0.3s ease;
    font-family: Helvetica, Arial, sans-serif;
}

.modal-header h3 {
    margin-top: 0;
    color: #42b983;
}

.modal-body {
    margin: 20px 0;
}

.modal-enter {
    opacity: 0;
}

.modal-leave-active {
    opacity: 0;
}

.modal-enter .modal-container,
.modal-leave-active .modal-container {
    -webkit-transform: scale(1.1);
    transform: scale(1.1);
}

</style>
