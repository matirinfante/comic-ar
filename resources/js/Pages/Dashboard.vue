<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import Welcome from '@/Components/Welcome.vue';
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
                <p>
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Similique nesciunt fuga autem ad, quidem velit ipsa molestiae deleniti omnis excepturi ipsum cum enim voluptatem officiis quibusdam molestias suscipit unde magni voluptas mollitia officia praesentium cumque sapiente. Voluptate ullam veniam sint quae maxime deleniti molestiae ea sequi numquam? Aperiam consequuntur mollitia cumque. Aliquam dignissimos ea sapiente iure, cumque perferendis dolor nisi beatae! Commodi, sapiente temporibus odit ab magnam, sit necessitatibus autem asperiores nisi sunt eum nihil! Eum, itaque optio. Recusandae impedit molestias sint ipsam vitae illum doloremque, non aspernatur laboriosam voluptatem cumque, quis blanditiis quod veniam officiis voluptatibus exercitationem libero ea.
                </p>
            </div>
        </div>
    </AppLayout>
</template>
