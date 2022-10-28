<script setup>
import { Head, Link } from '@inertiajs/inertia-vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import SectionTitle from '@/Components/SectionTitle.vue';
import SectionBorder from '@/Components/SectionBorder.vue';
</script>
<template>
    <AppLayout title="Usuarios">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                <span class="text-gray-500">Usuarios</span>
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounder-lg">
                    <pre>
                        <table class="table-auto w-full">
                            <thead>
                                <tr>
                                    <th class="p-3">ID</th>
                                    <th class="p-3">Nombre</th>
                                    <th class="p-3">Email</th>
                                    <th class="p-3">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="user in users" :key="user.id">
                                    <td class="p-3 border">{{user.id}}</td>
                                    <td class="p-3 border">{{user.name}}</td>
                                    <td class="p-3 border">{{user.email}}</td>
                                    <td class="p-3 border">Mod/Del</td>
                                </tr>
                            </tbody>
                        </table>
                    </pre>
                    
                </div>
                <SectionBorder />
            </div>
        </div>
    </AppLayout>
</template>
<script>
export default{
    //Como no tenemos admin lo dejo comentado
    // props:['users'],
    // components:{
    //     AppLayout
    // }
}
</script>
