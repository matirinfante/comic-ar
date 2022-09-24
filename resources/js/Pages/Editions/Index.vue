<script setup>
import { Head, Link } from '@inertiajs/inertia-vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import SectionBorder from '@/Components/SectionBorder.vue';

defineProps({
    editions: Object,
})
</script>
    
<template>
    <AppLayout title="Ediciones">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                <span class="text-gray-500">Ediciones</span>
            </h2>
        </template>

        <div>
            <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
                <!-- CONTENIDO CENTRAL -->

                <div class="flex flex-col md:flex-row justify-between mx-6 mb-5">
                    <!-- Buscador -->
                    <div class="md:w-6/12 px-4 py-2 bg-indigo-300 text-gray-600 rounded-full">
                        Buscar...
                    </div>
                    <!-- Botón de creación -->
                    <div class="md:mt-0 mt-4 w-fit px-4 py-2 bg-indigo-500 hover:bg-indigo-700 text-white rounded-md">
                        <Link :href="route('editions.create')" class="">Añadir Nueva
                        Edición
                        </Link>
                    </div>
                </div>
                <SectionBorder />
                <div class="grid sm:grid-cols-2 md:grid-cols-4 lg:grid-cols-6 mt-10">
                    <div v-for="edition in editions.data" :key="edition.id"
                        class="w-48 mx-auto mb-4 rounded-lg shadow-md hover:shadow-indigo-400 border-solid border-2 border-gray-300">
                        <Link :href="route('editions.show', edition)">
                        <!-- <img class="w-full h-50" :src="/img/edition.title+'.jpg'" @error="$event.target.src='/edition_cover.jpg'" :alt="edition.title" /> -->
                        <img class="w-full h-50" :src="'/img/edition_cover.jpg'" :alt="edition.title" />
                        <div class="text-center py-4 bg-gray-300 text-gray-500">
                            <h4 class="mb-3 text-xl font-semibold tracking-tight">{{edition.title}}</h4>
                        </div>
                        </Link>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
    