<script setup>
import { Head, Link } from '@inertiajs/inertia-vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import Stats from '@/Pages/Users/Stats.vue';
import NotFound from '@/Components/NotFound.vue';
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
                    <div class="sm:h-28 md:h-32 lg:h-40 overflow-hidden">
                        <img class="w-screen blur" :src="user.profile_photo_url">
                    </div>
                    <div class="absolute sm:left-20 md:left-20 lg:left-40 xl:left-52">
                        <div class="rounded-full sm:-ml-16 sm:-mt-10 sm:h-16 sm:w-16 md:-ml-8 md:-mt-12 md:h-20 md:w-20 lg:-mt-14 lg:h-24 lg:w-24 xl:h-28 xl:w-28 xl:pt-6 bg-black text-center border-x-[1px] border-t-[1px] border-white drop-shadow-xl">
                            <p class="text-white sm:text-lg md:mt-3 md:text-xl lg:text-2xl xl:text-3xl xl:mt-0 font-semibold">{{amount}}</p> 
                            <p class="text-white sm:text-sm lg:text-lg">COMICS</p>
                        </div>
                    </div>
                    <div class="absolute sm:left-24 md:left-40 lg:left-72 xl:left-96">
                        <img class="contrast-125 rounded-full -mt-10 ml-3 md:ml-0 sm:-mt-14 sm:h-28 sm:w-28 md:-mt-16 md:h-32 md:w-32 lg:-mt-20 lg:h-36 lg:w-36 xl:-mt-20 xl:h-40 xl:w-40 2xl:-mt-24 2xl:h-44 2xl:w-44 border-[2px] border-white bg-white drop-shadow-xl" :src="user.profile_photo_url">
                        <div class="text-center pt-5 font-bold">{{user.name}}</div>
                        
                    </div>
                    <div class="sm:h-28 md:h-32 lg:h-40 bg-white"></div>
                
                </div>
                <div class="flex my-3 bg-white py-2 pl-2" id="nav-bar">
                    <button v-on:click="actividad()" class="mx-2 hover:border-b-2 border-purple-400" :class="{'border-b-2':option=='actividad'}">Actividad</button>
                    <button v-on:click="stats()" class="mx-2 hover:border-b-2 border-purple-400" :class="{'border-b-2':option=='stats'}">Estadísticas</button>
                    <button v-on:click="badges()" class="mx-2 hover:border-b-2 border-purple-400" :class="{'border-b-2':option=='badges'}">Insignias</button>
                    <Link :href="route('objectives.index')" class="mx-2 hover:border-b-2 border-purple-400">Lectura</Link>
                </div>
                <div class="bg-white" id="display">

                    <!-- ACTIVIDAD -->
                    <div v-if="option=='actividad'">
                        <div v-if="volumes.length>0">
                            <p class="mb-4 pt-4 text-center tracking-wide text-lg font-semibold">ULTIMOS EN COMICTECA</p>
                            <div class="grid sm:grid-cols-2 sm:gap-1 md:grid-cols-3 xl:grid-cols-5 lg:gap-4 justify-items-center">
                                <div v-for="volume in volumes" :key="volume.id">
                                    <div class="relative">
                                        <img class="h-60" :src="volume.coverImage">
                                        <div
                                            class="font-semibold absolute inset-0 z-10 text-white text-center flex flex-col items-center justify-center opacity-0 bg-gray-900 hover:opacity-100 bg-opacity-50 duration-300">
                                            {{ volume.title }} #{{ volume.number }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="text-center mt-4 pb-4">
                                <Link :href="route('comictecas.index')" ><button class="bg-green-600 hover:bg-violet-700 text-white font-bold py-2 px-4 rounded text-lg">
                                    COMICTECA <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"  class="w-6 h-6 mx-auto inline fill-yellow-400 ml-2 mb-1"><path d="M0 256C0 397.4 114.6 512 256 512s256-114.6 256-256S397.4 0 256 0S0 114.6 0 256zM297 385c-9.4 9.4-24.6 9.4-33.9 0s-9.4-24.6 0-33.9l71-71L120 280c-13.3 0-24-10.7-24-24s10.7-24 24-24l214.1 0-71-71c-9.4-9.4-9.4-24.6 0-33.9s24.6-9.4 33.9 0L409 239c9.4 9.4 9.4 24.6 0 33.9L297 385z"/></svg>
                                    </button></Link>
                            </div>
                            
                        </div>
                        <!-- SI NO HAY TOMOS EN LA COMICTECA -->
                        <div v-else-if="volumes.length==0">
                            <div class="flex justify-center mb-5">
                                <p  class="font-bold text-lg mb-3 ml-3 mt-2 text-black px-2 border-double border-b-4 border-violet-700 drop-shadow-md">No tienes volúmenes en Comicteca</p>
                            </div>
                            <div class="flex justify-center">
                                <NotFound class="w-1/2 h-fit"/>
                            </div>
                        </div>
                    </div>

                    <!-- ESTADISTICAS -->
                    <div v-else-if="option=='stats'">
                        <Stats/>
                    </div>
                    
                    <!-- INSIGNIAS -->
                    <div v-else-if="option=='badges'">
                        Insignias
                    </div>
                </div>
                
            </div>
        </div>
    </AppLayout>
</template>
<script>
export default {
    props:{user:Object,volumes:Array,amount:Number},
    data(){
        return{
            option:"actividad",
        }
    },
    mounted(){
    },
    methods:{
        actividad(){
            this.option="actividad";
        },
        stats(){
            this.option="stats";
        },
        badges(){
            this.option="badges";
        }
    }
}
</script>