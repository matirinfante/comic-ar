<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import SectionTitle from '@/Components/SectionTitle.vue';
</script>

<template>
    <AppLayout title="Home">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Hola 
                <span class="text-gray-500">{{ $page.props.user.name }}</span>
            </h2>
        </template>

        <div>
            <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
                <!-- contenido central acá -->
                <SectionTitle>
                    <template #title>
                        Bienvenido a COMICAR
                    </template>
                    <template #description>
                        Este es el inicio
                    </template>

                </SectionTitle>
            </div>
        </div>
    </AppLayout>
</template>
