<template>
    <div class="grid sm:grid-cols-3 sm:gap-1 md:grid-cols-3 md:gap-2 lg:grid-cols-5 lg:gap-4 xl:gap-0 justify-items-center pt-4">
        <div v-for="badge in badges" :key="badge.id" class="pb-4">
            <div class="relative">
                <img :src=badge.imgUrl>
                <div class="font-semibold absolute inset-0 z-10 text-yellow-300 text-center flex flex-col items-center justify-center opacity-0 bg-gray-900 hover:opacity-100 bg-opacity-80 duration-300 rounded-xl cursor-default">
                    {{badge.legend}}
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import axios from 'axios';
export default {
    data(){
        return{
            badges:[]
        }
    },
    mounted(){
        this.show();
    },
    methods:{
        show(){
            axios.get('/showBadges').then(response=>{
                this.badges=response.data
            })
        }
    }
}
</script>