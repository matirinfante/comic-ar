<script setup>
import Api from '@/Components/Api.vue';
import AppLayout from '@/Layouts/AppLayout.vue';
</script>
<template>
    <AppLayout title="Búsqueda de tomos">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Búsqueda de tomos
            </h2>
        </template>
        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
            <div class="flex-row">
                <!-- CONTENIDO CENTRAL -->
                <div class="m-5">
                    <button type="button" v-on:click="goback"
                            class="bg-violet-600 hover:bg-violet-700 text-white font-bold py-2 px-4 rounded m-2">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" fill="currentColor"
                             class="w-5 h-5 inline">
                            <path
                                d="M205 34.8c11.5 5.1 19 16.6 19 29.2v64H336c97.2 0 176 78.8 176 176c0 113.3-81.5 163.9-100.2 174.1c-2.5 1.4-5.3 1.9-8.1 1.9c-10.9 0-19.7-8.9-19.7-19.7c0-7.5 4.3-14.4 9.8-19.5c9.4-8.8 22.2-26.4 22.2-56.7c0-53-43-96-96-96H224v64c0 12.6-7.4 24.1-19 29.2s-25 3-34.4-5.4l-160-144C3.9 225.7 0 217.1 0 208s3.9-17.7 10.6-23.8l160-144c9.4-8.5 22.9-10.6 34.4-5.4z"/>
                        </svg>
                        Regresar a la Edicion
                    </button>
                </div>
                <Api/>
            </div>
        </div>

    </AppLayout>
</template>
<script>
export default {
    methods: {
        goback() {
            window.history.back();
        }
    }
}
</script>
