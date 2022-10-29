<script setup>
import { Head, Link } from '@inertiajs/inertia-vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import axios from 'axios';

</script>
<template>
    <AppLayout title="Lista de deseados">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                ¡Esta es tu lista de deseados <span class="text-gray-500">{{$page.props.user.name}}</span>!
            </h2>
        </template>

        <div>
            <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
                <!-- CONTENIDO CENTRAL -->
                <div v-if="vol != null && vol.length > 0">
                    <div class="p-4 w-full max-w-md bg-white rounded-lg border shadow-md sm:p-8 mx-auto">
                        <div class="flex justify-between items-center mb-4">
                            <h5 class="text-xl font-bold leading-none text-gray-700 ">Qué será lo siguiente a leer?
                            </h5>
                            <p v-if="vol.length > 0" class="text-gray-400">(Total: {{vol.length}})</p>
                        </div>
                        <div class="flow-root">
                            <ul role="list" class="divide-y divide-gray-200 dark:divide-gray-700">
                                <div v-for="volume in vol" :key="volume.id">
                                    <li class="py-3 sm:py-4">
                                        <div class="flex items-center space-x-4">
                                            <div class="flex-shrink-0">
                                                <Link :href="route('volumes.show', volume.id)">
                                                <img class="w-12 h-16 rounded-lg border-purple-400 border-2"
                                                    :src="volume.coverImage" :alt="volume.title">
                                                </Link>
                                            </div>
                                            <div
                                                class="flex-1 min-w-0 border-2 border-white border-opacity-40 border-r-purple-400 px-2 hover:bg-purple-100">
                                                <Link :href="route('volumes.show', volume.id)">
                                                <p class="text-sm font-medium text-gray-900 truncate ">
                                                    {{volume.title}}
                                                </p>
                                                <p class="text-sm text-gray-500 truncate dark:text-gray-400">
                                                    N° {{volume.number}}
                                                </p>
                                                </Link>
                                            </div>
                                            <div
                                                class="inline-flex items-center text-base font-semibold text-gray-900 ">

                                                <form
                                                    v-on:submit.prevent="deleteItem(volume['pivot']['wishlist_id']+'*'+volume['pivot']['volume_id'])">
                                                    <button type="submit"
                                                        class="hover:text-red-700 transition delay-100">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                            viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                            class="w-6 h-6">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                                        </svg>
                                                    </button>
                                                </form>
                                            </div>
                                        </div>

                                    </li>
                                </div>
                            </ul>
                        </div>
                    </div>

                </div>
                <div v-else>
                    <div class="p-4 w-full max-w-md bg-white rounded-lg border shadow-md sm:p-8 mx-auto">
                        <div class="flex justify-between items-center mb-4">
                            <h5 class="text-xl font-bold leading-none text-gray-700 ">Añade aquí los tomos que deseas
                                leer como recordatorio
                            </h5>
                        </div>
                        <div class="flow-root">
                            <ul role="list" class="divide-y divide-gray-200 dark:divide-gray-700">
                                <li class="py-3 sm:py-4">
                                    <div class="flex justify-center space-x-4 border-2 py-4">
                                        <div class="flex-shrink-0">
                                            <p class="text-sm font-medium text-gray-500 truncate ">
                                                Sin elementos
                                            </p>
                                        </div>
                                    </div>
                                    <div class="flex justify-center space-x-4 mt-4">
                                        <p class="text-sm font-medium text-gray-500">
                                            Si te interesa algún tomo, puedes darle al botón 'Lo quiero' para que se
                                            añadan a esta lista.
                                        </p>
                                    </div>
                                    <div class="flex justify-center space-x-4 mt-8">
                                        <Link :href="route('editions.index')"
                                            class="inline-block px-6 py-2 border-2 border-purple-600 text-purple-600 font-medium text-xs leading-tight uppercase rounded-full hover:bg-purple-600 hover:text-white focus:outline-none focus:ring-0 transition duration-150 ease-in-out">
                                        Explorar Ediciones
                                        </Link>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
<script>
export default {
    props: {
        volumes: Object,
    },
    data() {
        return {
            vol: this.volumes,
        }
    },

    methods: {
        deleteItem($id) {
            axios.delete('/wishlists/' + $id)
                .then(response => {
                    // console.log('Cantidad original: ' + this.volumes.length);
                    // console.log('----------------------------------------');
                    // console.log(response.data);
                    this.vol = response.data;
                })
                .catch(error => { console.log(error.response) });
        }
    }
}
</script>

    