<script setup>
import { Head, Link } from '@inertiajs/inertia-vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import JetNavLink from '@/Components/NavLink.vue';

defineProps({
    edition: Object,
    volumes: Object,
    artworks: Object,
})

</script>

<template>
    <AppLayout :title="edition.title">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                <span class="text-gray-500">Artworks de {{ edition.title }}</span>
            </h2>
        </template>
        <div>
            <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
                <!-- CONTENIDO CENTRAL -->
                <div class="flex justify-end">
                    <JetNavLink :href="route('editions.edit', edition.id)"
                        class="text-gray-500 mr-10 mt-2 mb-2 md:mb-0 hover:text-gray-800">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                            <path
                                d="M5.433 13.917l1.262-3.155A4 4 0 017.58 9.42l6.92-6.918a2.121 2.121 0 013 3l-6.92 6.918c-.383.383-.84.685-1.343.886l-3.154 1.262a.5.5 0 01-.65-.65z" />
                            <path
                                d="M3.5 5.75c0-.69.56-1.25 1.25-1.25H10A.75.75 0 0010 3H4.75A2.75 2.75 0 002 5.75v9.5A2.75 2.75 0 004.75 18h9.5A2.75 2.75 0 0017 15.25V10a.75.75 0 00-1.5 0v5.25c0 .69-.56 1.25-1.25 1.25h-9.5c-.69 0-1.25-.56-1.25-1.25v-9.5z" />
                        </svg>
                        Editar Información
                    </JetNavLink>
                </div>
                <div class="mx-6 z-40 border-2 rounded-lg">
                    <div class="w-full pb-8 sm:px-0 bg-slate-700 rounded-t-lg">
                        <p class="px-4 text-md text-yellow-300 font-semibold sm:ml-4 md:ml-10 pt-6">
                            {{ edition.publisher }}
                        </p>
                        <h2 class="px-4 text-3xl font-bold text-white sm:ml-4 md:ml-10 mt-2">
                            {{ edition.title }}
                        </h2>
                        <p v-if="volumes.length > 0"
                            class="px-4 text-md text-green-400 font-semibold sm:ml-4 md:ml-10 pt-6">
                        <div class="flex">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="bi bi-files mr-2" viewBox="0 0 16 16">
                                <path
                                    d="M13 0H6a2 2 0 0 0-2 2 2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h7a2 2 0 0 0 2-2 2 2 0 0 0 2-2V2a2 2 0 0 0-2-2zm0 13V4a2 2 0 0 0-2-2H5a1 1 0 0 1 1-1h7a1 1 0 0 1 1 1v10a1 1 0 0 1-1 1zM3 4a1 1 0 0 1 1-1h7a1 1 0 0 1 1 1v10a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V4z" />
                            </svg>
                            <div v-if="volumes.length > 1">
                                {{ volumes.length }} tomos
                            </div>
                            <div v-else>
                                {{ volumes.length }} tomo
                            </div>
                        </div>
                        <p v-if="edition.isStandalone == 1" class="text-orange-300">
                            Tomo único
                        </p>
                        <p v-else class="text-orange-300">
                            Serie de tomos
                        </p>
                        </p>
                        <p class="px-4 text-md text-slate-400 font-light sm:ml-4 md:ml-10 pt-1">
                            {{ edition.format }}
                        </p>

                        <div class="flex justify-between">
                            <div class="bg-zinc-500 mt-4 py-1 pr-5 rounded-r-full">
                                <p class="text-gray-200 pl-4 md:pl-14">
                                    <span class="font-thin" v-if="edition.isClosed == 0">
                                        En curso
                                    </span>
                                    <span class="font-thin" v-else>
                                        Terminada
                                    </span>
                                </p>
                            </div>

                            <!-- agregar artwork -->
                            <div
                                class="bg-green-700 text-white hover:text-gray-100 hover:bg-green-600 mt-4 py-1 pr-5 rounded-l-full">
                                <p class="pl-4 md:pl-8">
                                    <Link :href="route('artworks.create')" :data="{id:edition.id}">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="w-6 h-6 inline">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M12 9v6m3-3H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    Agregar Artwork
                                    </Link>
                                </p>
                            </div>
                        </div>


                    </div>
                    <div class="h-12 bg-white shadow-lg flex border-y">
                        <div class="align-middle ml-10 my-auto">
                            <JetNavLink :href="route('editions.show', edition.id)">
                                Información
                            </JetNavLink>
                        </div>
                        <div class="align-middle ml-10 my-auto">
                            <JetNavLink :href="route('artworks.show', edition.id)"
                                :active="route().current('artworks.show', edition.id)">
                                Artworks
                            </JetNavLink>
                        </div>
                    </div>

                    <!-- Artworks -->
                    <div v-if="artworks.length > 0" class="bg-white">
                        <section class="overflow-hidden text-gray-700 pb-20">
                            <div class="container px-5 py-2 mx-auto lg:pt-12 lg:px-32">
                                <div class="flex flex-wrap -m-1 md:-m-2">
                                    <div class="flex flex-wrap w-1/3" v-for="art in artworks" :key="art.id">
                                        <div v-if="modalShow == false" class="w-full p-1 md:p-2 relative cursor-pointer"
                                            @click="showModal(art.imgUrl, art.usr)">
                                            <img class="block object-cover object-center w-full h-40 rounded-lg border-2"
                                                :src="art.imgUrl" :alt="art.description" />
                                            <div
                                                class="absolute inset-0 z-10 text-white text-center flex flex-col items-center justify-center opacity-0 bg-gray-900 hover:opacity-100 bg-opacity-50 duration-300 rounded-lg">
                                                {{art.title}}
                                            </div>
                                        </div>
                                        <div v-if="modalShow" class="w-full p-1 md:p-2">
                                            <img class="block object-cover object-center w-full h-40 rounded-lg"
                                                :src="art.imgUrl" :alt="art.title" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>
                    <div v-else>
                        <div class="text-gray-800 bg-white py-20 flex flex-row justify-center">
                            <p>Edición sin Artworks</p>
                        </div>
                    </div>


                    <!-- The Modal -->
                    <div v-if="modalShow" id="modal" @click-outside="clickOutside"
                        class="fixed top-0 left-0 z-80 w-screen h-screen bg-black/70 flex justify-center items-center">

                        <!-- The close button -->
                        <button class="fixed z-90 top-6 right-8 text-white text-5xl font-bold"
                            @click="modalShow = false"><svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>

                        <!-- A big image will be displayed here -->
                        <div class="relative">
                            <img :src="modalContent"
                                class="max-w-full md:max-w-[768px] lg:max-w-[1024px] max-h-[550px] object-cover" />
                            <div class="absolute inset-0 z-10 text-white flex flex-col">
                                <p class="bg-purple-700 w-fit pl-2 pr-4 bg-opacity-90 rounded-br-full">Artwork de {{author}}</p>
                            </div>
                        </div>
                    </div>



                </div>
            </div>
        </div>
    </AppLayout>
</template>
<script>
export default {
    data() {
        return {
            // ...
            modalShow: false,
            modalContent: null,
            author: null
        };
    },
    methods: {
        showModal(content, person) {
            this.modalShow = true
            this.modalContent = content
            this.author = person
        },
        clickOutside() {
            this.modalShow = false
        }
    }
}
</script>

