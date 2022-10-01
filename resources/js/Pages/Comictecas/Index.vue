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
    <div class="container mt-3">
        <p class="font-bold text-xl mb-3 ml-3">Cantidad de Volumenes: {{allVol.length}}</p>
        <div class="grid sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4 justify-items-center">
            <div v-for="volume in allVol" :key="volume.id" class="mb-3">
                <div class="relative">
                    <Link :href="route('volumes.show', volume.id)">
                    <img class="h-60" :src="volume.coverImage">
                    <div class="font-semibold absolute inset-0 z-10 text-white text-center flex flex-col items-center justify-center opacity-0 bg-gray-900 hover:opacity-100 bg-opacity-50 duration-300">{{volume.title}} #{{volume.number}}</div>
                    </Link>
                </div>
                <div class="text-center">
                    <button v-on:click="remove(volume.id)" class="inline-block w-full py-1 border-2 border-red-600 text-purple-600 hover:bg-red-600 hover:text-white transition duration-150 ease-in-out">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" class="w-4 h-4 mx-auto"><path d="M310.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L160 210.7 54.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L114.7 256 9.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L160 301.3 265.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L205.3 256 310.6 150.6z"/></svg>
                    </button>
                </div>
                
                
            </div>
        </div>
        
    </div>
    
    
</AppLayout>
</template>
<script>
export default{
    props:['comicteca','volumes'],
    components:{
        AppLayout
    },
    data(){
        return{
            allVol:this.volumes
        }
    },
    methods:{
        remove(id){
            axios.post('/comictecas',{volume_id:id,status:false}).then(response=>{this.allVol=response.data})
        }
    }
}
</script>