<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import SectionTitle from '@/Components/SectionTitle.vue';
import SearchInput from "@/Pages/Home/SearchInput.vue";
import Slider from "@/Pages/Home/Slider.vue";
</script>

<template>
    <AppLayout title="Home">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                ¡Buenas
                <span class="text-gray-500">{{ $page.props.user.name }}</span>! ¿Qué vas a leer hoy?
            </h2>
        </template>

        <div>
            <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
                <!-- contenido central acá -->
                <SearchInput/>
                <h2 class="font-medium leading-tight text-3xl mt-10 mb-2 text-blue-600 ">Últimas Novedades</h2>
                <Slider/>
                <h2 class="font-medium leading-tight text-3xl mt-6 mb-2 text-blue-600">Populares en ComicAR</h2>
                <Slider/>


            </div>
        </div>
    </AppLayout>
</template>
