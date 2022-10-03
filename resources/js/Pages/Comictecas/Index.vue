<script setup>
    import { Head, Link } from '@inertiajs/inertia-vue3';
    import AppLayout from '@/Layouts/AppLayout.vue';
</script>
<template>
<AppLayout title="Comicteca">
    <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                <span class="text-gray-500">Mi Comicteca</span>
            </h2>
    </template>
    <div class="pt-3 bg-violet-50">
        <p class="font-bold text-xl mb-3 ml-3 text-violet-700">Cantidad de Volumenes: {{cantVol}}</p>
        <div v-for="edition in allVol" class="divide-y divide-y-1 divide-blue-200">
            <p class="font-semibold text-lg mt-2 text-center">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" class="h-6 w-6 pb-1 inline">
                    <path d="M249.6 471.5c10.8 3.8 22.4-4.1 22.4-15.5V78.6c0-4.2-1.6-8.4-5-11C247.4 52 202.4 32 144 32C87.5 32 35.1 48.6 9 59.9c-5.6 2.4-9 8-9 14V454.1c0 11.9 12.8 20.2 24.1 16.5C55.6 460.1 105.5 448 144 448c33.9 0 79 14 105.6 23.5zm76.8 0C353 462 398.1 448 432 448c38.5 0 88.4 12.1 119.9 22.6c11.3 3.8 24.1-4.6 24.1-16.5V73.9c0-6.1-3.4-11.6-9-14C540.9 48.6 488.5 32 432 32c-58.4 0-103.4 20-123 35.6c-3.3 2.6-5 6.8-5 11V456c0 11.4 11.7 19.3 22.4 15.5z"/>
                </svg>
                {{edition[0].edition_title.title}}
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" class="h-6 w-6 pb-1 inline">
                    <path d="M249.6 471.5c10.8 3.8 22.4-4.1 22.4-15.5V78.6c0-4.2-1.6-8.4-5-11C247.4 52 202.4 32 144 32C87.5 32 35.1 48.6 9 59.9c-5.6 2.4-9 8-9 14V454.1c0 11.9 12.8 20.2 24.1 16.5C55.6 460.1 105.5 448 144 448c33.9 0 79 14 105.6 23.5zm76.8 0C353 462 398.1 448 432 448c38.5 0 88.4 12.1 119.9 22.6c11.3 3.8 24.1-4.6 24.1-16.5V73.9c0-6.1-3.4-11.6-9-14C540.9 48.6 488.5 32 432 32c-58.4 0-103.4 20-123 35.6c-3.3 2.6-5 6.8-5 11V456c0 11.4 11.7 19.3 22.4 15.5z"/>
                </svg>
            </p>
            <div  class="grid sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4 justify-items-center pt-2"> 
            
            <div v-for="volume in edition" :key="volume.id" class="mb-3">
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
            <!-- <hr class="divide-blue-600 "/> -->
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
            allVol:this.volumes,
            cantVol:0
        }
    },
    mounted(){
        this.countVol();
    },
    methods:{
        remove(id){
            axios.post('/comictecas.update',{volume_id:id,status:false}).then(response=>{this.allVol=response.data; this.countVol()})
        },
        countVol(){
            this.cantVol=0;
            this.allVol.forEach(element => {
                this.cantVol+=element.length;
            });
        }
    }
}
</script>