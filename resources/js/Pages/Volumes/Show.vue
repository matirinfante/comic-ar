<script setup>
import { Head, Link } from '@inertiajs/inertia-vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import JetNavLink from '@/Components/NavLink.vue';
import { useForm } from '@inertiajs/inertia-vue3';
import axios from 'axios';
import toastr from 'toastr-comicar';
import 'toastr-comicar/build/toastr.min.css'; 

const props = defineProps({
    volume: Object,
    edition: Object
})

const form = useForm({
    volume_id: props.volume[0]?.id,
    usr: props.volume[0]?.usr
});

const submit = () => {
    form.post(route('wishlists.store'));
    axios.post('/wishStatus').then(response=>{
        if (!response.data){
            toastr.options.positionClass="toast-bottom-right";
            toastr.options.progressBar = true;
            toastr.success('Insignia desbloqueada');    
        }
    });
};

function formatDate(date) {
    var year = date.getUTCFullYear();
    var month = date.getUTCMonth() + 1;
    var dt = date.getUTCDate();
    var hour = date.getUTCHours();
    var min = date.getUTCMinutes();

    if (dt < 10) {
        dt = '0' + dt;
    }
    if (month < 10) {
        month = '0' + month;
    }
    return (dt + '/' + month + '/' + year + ' - ' + hour + ':' + min);
}
</script>
                        
<template>
    <AppLayout :title="volume[0].title">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Tomo de <span class="text-gray-500">{{ volume[0].title }}</span>
            </h2>
        </template>

        <div>
            <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
                <!-- CONTENIDO CENTRAL -->
                <div class="flex justify-end">
                    <JetNavLink :href="route('volumes.edit', volume[0].id)"
                        class="text-gray-500 mr-10 mt-2 mb-2 md:mb-0 hover:text-gray-800 text-base">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                            <path
                                d="M5.433 13.917l1.262-3.155A4 4 0 017.58 9.42l6.92-6.918a2.121 2.121 0 013 3l-6.92 6.918c-.383.383-.84.685-1.343.886l-3.154 1.262a.5.5 0 01-.65-.65z" />
                            <path
                                d="M3.5 5.75c0-.69.56-1.25 1.25-1.25H10A.75.75 0 0010 3H4.75A2.75 2.75 0 002 5.75v9.5A2.75 2.75 0 004.75 18h9.5A2.75 2.75 0 0017 15.25V10a.75.75 0 00-1.5 0v5.25c0 .69-.56 1.25-1.25 1.25h-9.5c-.69 0-1.25-.56-1.25-1.25v-9.5z" />
                        </svg>
                        Editar Información
                    </JetNavLink>
                </div>
                <div class="mx-6 z-40 border-2 rounded-lg relative">
                    <div class="w-full pb-8 sm:px-0 bg-slate-700 rounded-t-lg h-48">
                        <div
                            class="h-44 md:h-52 lg:h-72 flex justify-start absolute left-2 md:left-10 top-2 md:top-10 border-2">
                            <img class="" :src="volume[0].coverImage" :alt="volume[0].title" />
                        </div>
                        <div
                            class="w-1/2 h-36 flex justify-start absolute left-32 md:left-44 lg:left-60 top-2 md:top-10">
                            <p class="text-white md:text-2xl font-bold ml-6">#{{ volume[0].number }}</p>
                        </div>

                    </div>
                    <div class="flex">
                        <div class="text-center w-3/12 hidden md:block">
                            <!-- empty div -->
                        </div>
                        <div class="h-fit text-center flex text-2xl">
                            <Link :href="route('editions.show', edition[0].id)"
                                class="text-gray-500 hover:text-gray-800 block sm:inline p-3">
                            {{ edition[0].title }}
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="w-6 h-6 inline">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                            </svg>
                            </Link>

                            <!-- añadir a lista de deseados -->

                            <!-- si no está en la lista de deseados -->
                            <div v-if="volume[0].inWishlist == 0"
                                class="text-base relative ml-12 sm:absolute sm:ml-0 my-4 right-6">
                                <form @submit.prevent="submit">
                                    <button type="submit" :disabled="form.processing">
                                        <p class="text-gray-400 hover:text-red-400 transition delay-150">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" class="w-6 h-6 inline">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" />
                                            </svg>
                                            ¡Lo quiero!
                                        </p>
                                    </button>
                                </form>
                            </div>

                            <!-- si ya está en la lista de deseados -->
                            <div v-if="volume[0].inWishlist == 1" class="text-base relative ml-12 sm:ml-0 sm:absolute my-4 right-6">
                                <p class="text-red-500">
                                    <Link :href="route('wishlists.index')">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="#F78182" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="w-6 h-6 inline">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" />
                                    </svg>
                                    En deseados
                                    </Link>

                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="border-y-2 bg-white pt-0 pb-10 md:pt-5 flex flex-col md:flex-row justify-between">
                        <div class="md:w-6/12">
                            <h2 class="text-lg font-bold text-gray-600 ml-10 mt-6 md:mt-8 lg:mt-20">
                                Argumento
                            </h2>
                            <p v-if="volume[0].argument != null" class="text-mm text-gray-700 px-10">
                                {{ volume[0].argument }}
                            </p>
                            <p v-else class="text-mm text-gray-700 px-10">
                                El tomo/volúmen no cuenta con un argumento actualmente
                            </p>
                        </div>

                        <div class="md:w-6/12 md:pl-36">
                            <h2 class="text-lg font-bold text-gray-600 ml-10 mt-10 md:mt-8 lg:mt-20">
                                ISBN
                            </h2>
                            <p v-if="volume[0].ISBN != null" class="text-mm text-gray-700 px-10 w-50">
                                {{ volume[0].ISBN }}
                            </p>
                            <p v-else class="text-mm text-gray-700 px-10">
                                El tomo/volúmen no cuenta con un ISBN actualmente
                            </p>
                        </div>
                    </div>

                    <!-- última actualización (sin formato de fecha) -->
                    <div class="bg-slate-200 flex flex-col md:flex-row justify-between">
                        <div class="md:w-6/12 py-2">
                            <h2 class="text-lg font-bold text-gray-600 ml-10">
                                Última modificación
                            </h2>
                            <p v-if="volume[0].updated_at != null" class="text-mm text-gray-700 px-10">
                                {{ formatDate(new Date(volume[0].updated_at)) }}
                            </p>
                            <p v-else class="text-mm text-gray-700 px-10">
                                No disponible
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
                        