<script setup>
import { Head, Link } from '@inertiajs/inertia-vue3';
import AppLayout from '@/Layouts/AppLayout.vue';


</script>
<template>
    <AppLayout title="Perfil">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Mi Perfil
            </h2>
        </template>
        <div class="pt-20 px-40" id="container">
            <div class="" id="profile">
                <div class="relative" id="user">
                    <div class="h-40 overflow-hidden">
                        <img class="w-screen blur" :src="user.profile_photo_url">
                    </div>
                    <div class="absolute sm:left-20 md:left-64 lg:left-60 xl:left-96">
                        <!-- <img class="rounded-full -mt-10 md:-mt-16 ml-3 md:ml-0 h-20 w-20 md:h-40 md:w-40 border-[2px] border-white bg-white" src="https://i.pinimg.com/originals/cb/77/0a/cb770aa68fb58ed3ba29172981620c56.jpg"> -->
                        <img class="rounded-full -mt-10 md:-mt-16 ml-3 md:ml-0 h-20 w-20 md:h-40 md:w-40 border-[2px] border-white bg-white" :src="user.profile_photo_url">
                        <div class="text-center">{{user.name}}</div>
                        
                    </div>
                    <div class="h-40 bg-white"></div>
                
                </div>
                <div class="flex my-3 bg-white py-2 pl-2" id="nav-bar">
                    <button v-on:click="actividad()" class="hover:text-red-500">Actividad</button>
                    <button v-on:click="stats()" class="hover:text-red-500">Estadísticas</button>
                    <div class="mx-2 hover:text-red-500">Insignias</div>
                    <Link :href="route('objectives.index')" class="hover:text-red-500">Lectura</Link>
                </div>
                <div class="bg-white" id="display">
                    <div v-if="option=='lectura'">
                        Lectura
                    </div>
                    <div v-else-if="option=='stats'">
                        Estadisticas
                    </div>
                    <div v-else>
                        CONTENIDO
                    </div>
                </div>
                
            </div>
        </div>
    </AppLayout>
</template>
<script>
export default {
    props:{user:Object},
    data(){
        return{
            option:""
        }
    },
    methods:{
        actividad(){
            this.option="actividad";
        },
        stats(){
            this.option="stats";
        }
    }
}
</script>