<script setup>
    import { Head, Link } from '@inertiajs/inertia-vue3';
    import AppLayout from '@/Layouts/AppLayout.vue';
</script>
<template>
<AppLayout title="Comicteca">
    <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                <span class="text-gray-500">Mi Comicteca Bronx</span>
            </h2>
    </template>
    <!-- {{volumes}} -->
    <div v-for="volume in volumes" :key="volume.id">
        <img class="h-60" :src="volume.coverImage">
        <p class="font-semibold">{{volume.title}} #{{volume.number}}</p>
    </div>
    
</AppLayout>
</template>
<script>
export default{
    props:['comicteca','volumes'],
    components:{
        AppLayout
    }
}
</script>