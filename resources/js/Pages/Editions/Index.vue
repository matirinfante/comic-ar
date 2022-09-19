<script setup>
import { Head, Link } from '@inertiajs/inertia-vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import SectionTitle from '@/Components/SectionTitle.vue';
import SectionBorder from '@/Components/SectionBorder.vue';
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
                <SectionTitle>
                    <template #title>
                        Ediciones actuales
                    </template>
                    <template #description>
                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Atque consectetur iure voluptatibus aut
                        quos, ad, nam quasi, eveniet vero itaque repudiandae dolorem eligendi ut! Velit dignissimos
                        vitae molestias! Unde, veritatis.
                    </template>
                </SectionTitle>
            </div>
        </div>
    </AppLayout>
</template>
    