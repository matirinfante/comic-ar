<script setup>
    import { Head, Link } from '@inertiajs/inertia-vue3';
    import AppLayout from '@/Layouts/AppLayout.vue';
</script>
<template>
<AppLayout title="Comicteca">
    <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                <span class="text-gray-500">Tu Comicteca</span>
            </h2>
    </template>
    {{comicteca}}
    
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