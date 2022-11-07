<template>
    <div id="container" class="divide-y divide-fuchsia-400">
        <div v-if="messageon">
            <div class="mt-2 text-left" v-for="mensaje in message">{{mensaje}}</div>
        </div>
        <div v-else>
            <p class="text-center">No posee objetivos pendientes</p>
        </div>
        <div>
            <p>Wishlists: {{totalWish}}</p>
            <p>Listas: {{totalList}}</p>
            <p>Objetivos: {{completed}}</p>
        </div>
        <div>
        </div>
    </div>
</template>
<script>
import axios from 'axios'
export default {
    data(){
        return{
            message:"",
            messageon:false,
            totalWish:0,
            totalList:0,
            completed:0,
        }
    },
    mounted(){
        this.getNotif();
        this.stats();
    },
    methods:{
        getNotif(){
            var option=3;
            axios.get('/objnotifications-ask',{params:{option:option}}).then(response=>{
            if (response.data!=""){
                this.message=response.data.split('</br>');
                this.messageon=true;
                }
            });
        },
        stats(){
            axios.get('/getStats').then(response=>{
                console.log(response.data);
                this.totalWish=response.data.volInWish;
                this.totalList=response.data.booklists;
                this.completed=response.data.completedObj;
            });
        }
    }
}
</script>