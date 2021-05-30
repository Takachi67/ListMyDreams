<template>
    <div class="w-full mt-10 mb-10">
        <div class="w-full h-20 pl-5 pr-5 bg-blue-100 flex justify-between items-center">
            <div class="h-full flex flex-col justify-center items-center">
                <h2 class="text-2xl font-bold">{{ name }}</h2>
            </div>
        </div>
        <ul class="w-full border border-blue-100">
            <li class="flex flex-col md:flex-row justify-between items-center hover:bg-gray-100 p-5" v-for="item in items">
                <div>
                    <h2><span class="text-xl font-bold">{{ item.name }}</span> ( <a class="underline text-blue-600" :href="routes.wishlist.show + '/' + item.wishlist.id">{{ item.wishlist.name }}</a> )</h2>
                    <p><span class="font-bold">{{ translations.reservations.where_to_find }}:</span> <a class="underline text-blue-600" :href="item.link">{{ translations.items.link }}</a></p>
                    <p><span class="font-bold">{{ translations.items.priority }}:</span> {{ he.decode(translations.items.priorities[item.priority]) }}</p>
                    <p v-if="item.comment"><span class="font-bold">{{ translations.items.comment }}:</span> {{ item.comment }}</p>
                    <textarea v-model="item.reservation.notes" class="max-h-20 w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50" :placeholder="translations.reservations.notes"></textarea>
                    <button class="btn btn-primary" @click="saveNotes(item)">{{ translations.reservations.save_notes }}</button>
                </div>
                <div class="mt-5 md:mt-0 md:float-right">
                    <div class="flex justify-center items-center">
                        <span :class="['mt-0.5', !item.reservation.has_bought ? 'font-bold' : '']">{{ translations.reservations.not_bought }}</span>
                        <label class="switch ml-2 mr-2">
                            <input :class="[item.reservation.has_bought ? 'checked' : '']" @change="hasBought(item)" type="checkbox" :value="item.reservation.has_bought">
                            <span class="slider round"></span>
                        </label>
                        <span :class="['mt-0.5', item.reservation.has_bought ? 'font-bold' : '']">{{ translations.reservations.bought }}</span>
                    </div>
                    <div class="flex justify-center">
                        <button class="btn btn-secondary mt-2" @click="unreserve(item)">{{ translations.items.unreserve }}</button>
                    </div>
                </div>
            </li>
        </ul>
    </div>
</template>

<script>
import { computed, ref } from 'vue'
import feather from 'feather-icons'
import axios from 'axios'
import Item from '../models/Item'
import Swal from 'sweetalert2'

export default {
    name: 'WishlistReservations',
    props: {
        name: {
            type: String,
            default: ''
        },
        defaultItems: {
            type: Array,
            default: []
        }
    },
    setup(props) {
        let translations = window.translations,
            routes = window.routes,
            he = window.he,
            items = ref(props.defaultItems)

        const infoIcon = computed(() => {
            return feather.icons['info'].toSvg()
        })

        function hasBought(item) {
            item.reservation.has_bought = !item.reservation.has_bought
            axios.post(routes.reservations.hasBought, {
                item_id: item.id,
                has_bought: item.reservation.has_bought
            })
        }

        function unreserve(item) {
            if (item.wishlist.status === 'expired') {
                Swal.fire({
                    text: he.decode(translations.wishlists.expired_message),
                    icon: 'error',
                    confirmButtonText: 'OK'
                })
            } else {
                Swal.fire({
                    title: translations.wishlists.unreserve_question.replace(':item:', item.name),
                    showDenyButton: true,
                    showCancelButton: false,
                    confirmButtonText: translations.wishlists.create_buttons.yes,
                    denyButtonText: translations.wishlists.create_buttons.no
                }).then((result) => {
                    if (result.isConfirmed) {
                        axios.post(routes.wishlist.unreserve, {
                            id: item.id
                        }).then((response) => {
                            let index = items.value.findIndex(item => item.id === response.data.id)
                            if (index !== -1) {
                                items.value.splice(index, 1)
                                Swal.fire({
                                    title: translations.items.success,
                                    text: translations.items.successfully_unreserved.replace(':item:', item.name),
                                    icon: 'success',
                                    confirmButtonText: 'OK'
                                })
                            }
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
        }

        function saveNotes(item) {
            axios.post(routes.reservations.saveNotes, {
                reservation_id: item.reservation.id,
                notes: item.reservation.notes
            }).then(() => {
                Swal.fire({
                    title: translations.items.success,
                    text: translations.reservations.notes_saved,
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

        return {
            translations,
            routes,
            he,
            items,
            infoIcon,
            hasBought,
            unreserve,
            saveNotes
        }
    }
}
</script>

<style scoped>

/* The switch - the box around the slider */
.switch {
    position: relative;
    display: inline-block;
    width: 60px;
    height: 34px;
}

/* Hide default HTML checkbox */
.switch input {
    opacity: 0;
    width: 0;
    height: 0;
}

/* The slider */
.slider {
    position: absolute;
    cursor: pointer;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: #ccc;
    -webkit-transition: .4s;
    transition: .4s;
}

.slider:before {
    position: absolute;
    content: "";
    height: 26px;
    width: 26px;
    left: 4px;
    bottom: 4px;
    background-color: white;
    -webkit-transition: .4s;
    transition: .4s;
}

.checked + .slider {
    background-color: #75a9f9;
}

input:focus + .slider {
    box-shadow: 0 0 1px #75a9f9;
}

.checked + .slider:before {
    -webkit-transform: translateX(26px);
    -ms-transform: translateX(26px);
    transform: translateX(26px);
}

/* Rounded sliders */
.slider.round {
    border-radius: 34px;
}

.slider.round:before {
    border-radius: 50%;
}

</style>
