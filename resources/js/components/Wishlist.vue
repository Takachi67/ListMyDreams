<template>
    <transition name="modal">
        <div class="modal-mask" @click="closeModal" v-show="showQuestionModal">
            <div class="modal-wrapper">
                <div class="modal-container md:w-1/2" @click.stop>
                    <div class="modal-header">
                        <slot name="header">
                            <h4 class="text-3xl">{{ translations.questions.question }}</h4>
                        </slot>
                    </div>
                    <div class="modal-body">
                        <slot name="body">
                            <div>
                                <input :placeholder="translations.questions.your_question" type="text" v-on:keyup.enter="sendQuestion" v-model="question" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                            </div>
                        </slot>
                    </div>
                    <div class="modal-footer flex justify-end items-center">
                        <slot name="footer">
                            <button class="btn btn-primary" @click="sendQuestion">{{ translations.messenger.send }}</button>
                        </slot>
                    </div>
                </div>
            </div>
        </div>
    </transition>
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
                    <div class="modal-footer flex justify-between items-center">
                        <slot name="footer">
                            <button class="btn btn-primary" @click="closeModal">{{ translations.default.close }}</button>
                            <button class="btn btn-secondary" @click="unreserve(openedItem.id)" v-if="wishlist.status !== 'expired' && openedItem.is_reserved && canEdit && user && openedItem.reserved_user_id === user.id">{{ translations.items.unreserve }}</button>
                            <button class="btn btn-tertiary" @click="reserve(openedItem.id)" v-if="wishlist.status !== 'expired' && !openedItem.is_reserved && canEdit && user">{{ translations.items.reserve }}</button>
                            <span class="text-red-700 mt-0.5" v-if="wishlist.status === 'expired' && canEdit && user">{{ he.decode(translations.wishlists.expired_message) }}</span>
                        </slot>
                    </div>
                </div>
            </div>
        </div>
    </transition>
    <p class="text-red-700 ml-10 md:ml-20 mt-6 flex items-center" v-if="wishlist.status === 'expired'">
        <i v-html="infoIcon"></i>
        <span class="mt-1 ml-3">{{ he.decode(translations.wishlists.expired_message) }}</span>
    </p>
    <div class="mt-5 mr-10 md:mr-20 flex justify-end">
        <button v-if="wishlist.status !== 'expired' && canEdit" @click="openQuestionModal" class="ml-auto btn btn-primary">{{ translations.questions.ask_question }}</button>
    </div>
    <div class="mt-6 mb-6 ml-4 mr-4 md:ml-20 md:mr-20 relative">
        <ul class="paper" :style="{ '--color': wishlist.border_color }">
            <li class="item" @click="openModal(item)" v-for="item in wishlist.items" :style="{ borderBottom: '1px dotted ' + wishlist.line_color, color: wishlist.text_color }">
                {{ item.name }}
                <div v-if="item.is_reserved && canEdit" class="flex items-center float-right mr-2">
                    <span class="text-red-600 mr-2 mt-0.5 flex items-center">{{ translations.wishlists.already_reserved }}</span>
                    <i class="text-red-600" v-html="clockIcon"></i>
                </div>
                <div v-if="!item.is_reserved && canEdit" class="flex items-center float-right mr-2">
                    <span class="text-green-600 mr-2 mt-0.5 flex items-center">{{ translations.wishlists.available }}</span>
                    <i class="text-green-600" v-html="checkIcon"></i>
                </div>
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
        },
        canEdit: {
            type: Boolean,
            default: false
        }
    },
    setup(props) {
        let wishlist = ref(props.defaultWishlist),
            translations = window.translations,
            routes = window.routes,
            he = window.he,
            showModal = ref(false),
            showQuestionModal = ref(false),
            openedItem = ref(new Item()),
            question = ref('')

        const clockIcon = computed(() => {
            return feather.icons['clock'].toSvg()
        }), checkIcon = computed(() => {
            return feather.icons['check-circle'].toSvg()
        }), infoIcon = computed(() => {
            return feather.icons['info'].toSvg()
        })

        function openModal(item) {
            openedItem.value = item
            showModal.value = true
        }

        function openQuestionModal() {
            showQuestionModal.value = true
        }

        function closeModal() {
            showModal.value = false
            showQuestionModal.value = false
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

        function sendQuestion() {
            axios.post(routes.questions.ask, {
                list_id: wishlist.value.id,
                message: question.value
            }).then(() => {
                question.value = ''
                closeModal()
                Swal.fire({
                    title: translations.items.success,
                    text: translations.questions.question_sent,
                    icon: 'success',
                    confirmButtonText: 'OK'
                })
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
            showQuestionModal,
            openedItem,
            question,
            clockIcon,
            checkIcon,
            infoIcon,
            openModal,
            openQuestionModal,
            closeModal,
            reserve,
            unreserve,
            sendQuestion
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

</style>
