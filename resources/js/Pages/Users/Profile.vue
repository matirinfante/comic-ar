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
                    <div class="absolute sm:left-20 md:left-20 lg:left-40 xl:left-52">
                        <div class="rounded-full -mt-10 md:-mt-16 ml-3 md:ml-0 h-20 w-20 md:h-28 md:w-28 xl:pt-10 pl-5 bg-green-500">{{amount}} COMICS</div>
                    </div>
                    <div class="absolute sm:left-20 md:left-64 lg:left-60 xl:left-96">
                        <!-- <img class="rounded-full -mt-10 md:-mt-16 ml-3 md:ml-0 h-20 w-20 md:h-40 md:w-40 border-[2px] border-white bg-white" src="https://i.pinimg.com/originals/cb/77/0a/cb770aa68fb58ed3ba29172981620c56.jpg"> -->
                        <img class="contrast-125 rounded-full -mt-10 md:-mt-20 ml-3 md:ml-0 h-20 w-20 md:h-40 md:w-40 border-[2px] border-white bg-white" :src="user.profile_photo_url">
                        <div class="text-center pt-5 font-bold">{{user.name}}</div>
                        
                    </div>
                    <div class="h-40 bg-white"></div>
                
                </div>
                <div class="flex my-3 bg-white py-2 pl-2" id="nav-bar">
                    <button v-on:click="actividad()" class="mx-2 hover:text-red-500">Actividad</button>
                    <button v-on:click="stats()" class="mx-2 hover:text-red-500">Estadísticas</button>
                    <div class="mx-2 hover:text-red-500">Insignias</div>
                    <Link :href="route('objectives.index')" class="mx-2 hover:text-red-500">Lectura</Link>
                </div>
                <div class="bg-white" id="display">
                    <div v-if="option=='actividad'">
                        <p class="mb-4 pt-4 text-center">ULTIMOS EN COMICTECA</p>
                        <div class="grid grid-cols-5 gap-4 justify-items-center">
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
                            <Link :href="route('comictecas.index')" ><button class="bg-green-600 hover:bg-violet-700 text-white font-bold py-2 px-4 rounded">VER MAS</button></Link>
                        </div>
                        
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
    props:{user:Object,volumes:Array,amount:Number},
    data(){
        return{
            option:""
        }
    },
    mounted(){
        console.log(this.volumes);
        console.log(this.amount);
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