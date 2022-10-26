<script setup>
import { Head, Link } from '@inertiajs/inertia-vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import JetNavLink from '@/Components/NavLink.vue';
import SectionBorder from '@/Components/SectionBorder.vue';
import axios from 'axios';


defineProps({
    booklist: Object,
    volumes: Object,
})

function formatDate(date) {
    var year = date.getUTCFullYear();
    var month = date.getUTCMonth() + 1;
    var dt = date.getUTCDate();


    if (dt < 10) {
        dt = '0' + dt;
    }
    if (month < 10) {
        month = '0' + month;
    }
    return (dt + '/' + month + '/' + year);
}
</script>

<template>
    <AppLayout :title="booklist.name">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                <span class="text-gray-500">Lista: {{ booklist.name }}</span>
            </h2>
        </template>

        <div>
            <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
                <!-- CONTENIDO CENTRAL -->

                <div v-if="booklist.editPermission == 'y'" class="flex justify-end">
                    <JetNavLink :href="route('booklists.edit', booklist.id)"
                        class="text-gray-500 mr-10 mt-2 mb-2 md:mb-0 hover:text-gray-800">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                            <path
                                d="M5.433 13.917l1.262-3.155A4 4 0 017.58 9.42l6.92-6.918a2.121 2.121 0 013 3l-6.92 6.918c-.383.383-.84.685-1.343.886l-3.154 1.262a.5.5 0 01-.65-.65z" />
                            <path
                                d="M3.5 5.75c0-.69.56-1.25 1.25-1.25H10A.75.75 0 0010 3H4.75A2.75 2.75 0 002 5.75v9.5A2.75 2.75 0 004.75 18h9.5A2.75 2.75 0 0017 15.25V10a.75.75 0 00-1.5 0v5.25c0 .69-.56 1.25-1.25 1.25h-9.5c-.69 0-1.25-.56-1.25-1.25v-9.5z" />
                        </svg>
                        Editar
                    </JetNavLink>
                </div>

                <div class="mx-6 z-40 border-2 rounded-lg">
                    <div class="w-full pb-8 bg-slate-500 rounded-t-lg text-center">
                        <p class="text-md text-yellow-300 font-semibold pt-6">
                            <span class="text-white">Lista de</span> {{ booklist.usr }}
                        </p>
                        <h2 class="text-3xl font-bold text-white mt-2">
                            {{ booklist.name }}
                        </h2>

                        <div class="flex text-md text-green-400 font-semibold pt-6 justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="bi bi-files mr-2" viewBox="0 0 16 16">
                                <path
                                    d="M13 0H6a2 2 0 0 0-2 2 2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h7a2 2 0 0 0 2-2 2 2 0 0 0 2-2V2a2 2 0 0 0-2-2zm0 13V4a2 2 0 0 0-2-2H5a1 1 0 0 1 1-1h7a1 1 0 0 1 1 1v10a1 1 0 0 1-1 1zM3 4a1 1 0 0 1 1-1h7a1 1 0 0 1 1 1v10a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V4z" />
                            </svg>
                            <div v-if="volumes.length < 1">
                                Sin tomos
                            </div>
                            <div v-if="volumes.length == 1">
                                {{ volumes.length }} tomo
                            </div>
                            <div v-if="volumes.length > 1">
                                {{ volumes.length }} tomos
                            </div>
                        </div>
                        <div v-if="booklist.classification == 'Guía de lectura'"
                            class="w-fit bg-gradient-to-r from-cyan-500 to-blue-500 text-white rounded-full text-md font-semibold mx-auto px-4 mt-4">
                            {{ booklist.classification }}
                        </div>
                        <div v-if="booklist.classification == 'Crossover'"
                            class="w-fit bg-gradient-to-br from-green-400 to-blue-600 text-white rounded-full text-md font-semibold mx-auto px-4 mt-4">
                            {{ booklist.classification }}
                        </div>
                        <div v-if="booklist.classification == 'Personal'"
                            class="w-fit bg-gradient-to-r from-purple-500 to-pink-500 text-white rounded-full text-md font-semibold mx-auto px-4 mt-4">
                            {{ booklist.classification }}
                        </div>
                    </div>

                    <div class="bg-white py-10 text-center">
                        <!-- Información/Descripción -->
                        <h2 class="text-2xl font-bold text-gray-600">
                            Descripción
                        </h2>
                        <p v-if="booklist.description != null" class="text-mm text-gray-700 px-10 pt-6 sm:px-40">
                            {{ booklist.description }}
                        </p>
                        <p v-else class="text-mm text-gray-700 px-10 pt-6">
                            La lista no cuenta con una descripción
                        </p>
                    </div>


                    <div v-if="volumes.length > 0" class="bg-white">
                        <SectionBorder />
                        <!-- Tomos/Volumenes -->
                        <div class="grid sm:grid-cols-3 md:grid-cols-6 lg:grid-cols-6">
                            <div v-for="volume in volumes" :key="volume.id" class="w-26 mx-2 mb-4 rounded-lg">
                                <Link :href="route('volumes.show', volume.id)">
                                <div class="relative">
                                    <img class="w-full h-50" :src="volume.coverImage" :alt="volume.title" />
                                    <div
                                        class="absolute inset-0 z-10 text-white text-center flex flex-col items-center justify-center opacity-0 bg-gray-900 hover:opacity-100 bg-opacity-50 duration-300">
                                        {{ volume.title }} #{{ volume.number }}
                                    </div>
                                </div>
                                </Link>
                            </div>
                        </div>
                    </div>

                    <!-- última actualización (sin formato de fecha) -->
                    <div class="bg-slate-200 flex flex-col md:flex-row justify-between">
                        <div class="md:w-6/12 py-2">
                            <h2 class="text-lg font-bold text-gray-600 ml-10">
                                Creación
                            </h2>
                            <p v-if="booklist.created_at != null" class="text-mm text-gray-700 px-10">
                                {{ formatDate(new Date(booklist.created_at)) }}
                            </p>
                            <p v-else class="text-mm text-gray-700 px-10">
                                No disponible
                            </p>
                        </div>
                        <div class="flex justify-end">
                            <form v-if="booklist.editPermission == 'y'" v-on:submit.prevent="deleteItem(booklist.id)">
                                <button type="submit" class="text-xs text-gray-500 mr-2 mb-2 md:mb-0 md:mt-5 hover:text-red-900">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="w-6 h-6 inline">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                    </svg>Eliminar
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </AppLayout>
</template>
<script>
export default {
    methods: {
        deleteItem($id) {

            this.$swal({
                title: "Seguro que quiere eliminar la lista?",
                text: "Esta acción es irreversible",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                confirmButtonText: "Eliminar",
                cancelButtonText: 'Cancelar',
            }).then((result) => { // <--
                if (result.value) { // <-- if confirmed
                    axios.delete('/booklists/' + $id)
                        .then(response => {
                            this.$swal(
                                'Eliminada!',
                                response.data,
                                'success'
                            ).then((result) => { // <--
                                if (result.value) { // <-- if confirmed
                                    // location.href = '/booklists';
                                    alert('Refrescar...');
                                }
                            });
                        })
                        .catch(error => { console.log(error.response) });
                }
            });

            // axios.delete('/booklists/' + $id)
            //     .then(response => {
            //         this.$swal(
            //             'Eliminado!',
            //             response.data,
            //             'success'
            //         )
            //     })
            //     .catch(error => { console.log(error.response) });
        }
    }
}
</script>
