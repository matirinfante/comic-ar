<template>
    <div class="grid sm:grid-cols-3 sm:gap-1 md:grid-cols-3 md:gap-2 lg:grid-cols-5 lg:gap-4 xl:gap-0 justify-items-center py-4">
        <div v-for="badge in badges" :key="badge.id">
            <img :src=badge.imgUrl :title=badge.name>
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