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
                            <p class="text-xl"><b>{{ translations.items.comment }}</b>: {{ openedItem.comment }}</p>
                        </slot>
                    </div>
                    <div class="modal-footer flex justify-between">
                        <slot name="footer">
                            <button class="btn btn-primary" @click="closeModal">{{ translations.default.close }}</button>
                            <button class="btn btn-secondary" @click="unreserve(openedItem.id)" v-if="openedItem.is_reserved && openedItem.reserved_user_id === user.id">{{ translations.items.unreserve }}</button>
                            <button class="btn btn-tertiary" @click="reserve(openedItem.id)" v-if="!openedItem.is_reserved">{{ translations.items.reserve }}</button>
                        </slot>
                    </div>
                </div>
            </div>
        </div>
    </transition>
    <div class="mt-6 mb-6 ml-10 mr-10 md:ml-20 md:mr-20 relative">
        <ul class="paper" :style="{ '--color': wishlist.border_color }">
            <li class="item" @click="openModal(item)" v-for="item in wishlist.items" :style="{ borderBottom: '1px dotted ' + wishlist.line_color, color: wishlist.text_color }">
                {{ item.name }}
                <i class="float-right mr-2 text-green-600" v-if="item.is_reserved" v-html="checkIcon"></i>
                <i class="float-right mr-2 text-red-600" v-else v-html="clockIcon"></i>
            </li>
            <li v-for="i in [...Array(10 - wishlist.items.length).keys()]" :style="{ borderBottom: '1px dotted ' + wishlist.line_color, color: wishlist.text_color }"></li>
        </ul>
    </div>
</template>

<script>
import { ref, computed } from 'vue'
import Item from '../models/Item'
import Wishlist from '../models/Wishlist'
import feather from 'feather-icons'
import axios from 'axios'
import Swal from "sweetalert2";

export default {
    name: 'Wishlist',
    props: {
        defaultWishlist: {
            type: Wishlist,
            default: new Wishlist()
        },
        user: {
            type: Object,
            default: {}
        }
    },
    setup(props) {
        let wishlist = ref(props.defaultWishlist),
            translations = window.translations,
            routes = window.routes,
            he = window.he,
            showModal = ref(false),
            openedItem = ref(new Item())

        const clockIcon = computed(() => {
            return feather.icons['clock'].toSvg()
        })

        const checkIcon = computed(() => {
            return feather.icons['check-circle'].toSvg()
        })

        function openModal(item) {
            openedItem.value = item
            showModal.value = true
        }

        function closeModal() {
            showModal.value = false
        }

        function reserve(id) {
            axios.post(routes.wishlist.reserve, {
                id: id
            }).then((response) => {
                let index = wishlist.value.items.findIndex(item => item.id === response.data.id)
                if (index !== -1) {
                    wishlist.value.items[index] = new Item(response.data)
                    closeModal()
                    Swal.fire({
                        title: translations.items.success,
                        text: translations.items.successfully_reserved.replace(':item:', wishlist.value.items[index].name),
                        icon: 'success',
                        confirmButtonText: 'OK'
                    })
                }
            }).catch((error) => {
                closeModal()
                Swal.fire({
                    text: error.response.data.message,
                    icon: 'error',
                    confirmButtonText: 'OK'
                })
            })
        }

        function unreserve(id) {
            axios.post(routes.wishlist.unreserve, {
                id: id
            }).then((response) => {
                let index = wishlist.value.items.findIndex(item => item.id === response.data.id)
                if (index !== -1) {
                    wishlist.value.items[index] = new Item(response.data)
                    closeModal()
                    Swal.fire({
                        title: translations.items.success,
                        text: translations.items.successfully_unreserved.replace(':item:', wishlist.value.items[index].name),
                        icon: 'success',
                        confirmButtonText: 'OK'
                    })
                }
            }).catch((error) => {
                closeModal()
                Swal.fire({
                    text: error.response.data.message,
                    icon: 'error',
                    confirmButtonText: 'OK'
                })
            })
        }

        return {
            wishlist,
            translations,
            he,
            showModal,
            openedItem,
            clockIcon,
            checkIcon,
            openModal,
            closeModal,
            reserve,
            unreserve
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
.paper .item {
    cursor: pointer;
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
