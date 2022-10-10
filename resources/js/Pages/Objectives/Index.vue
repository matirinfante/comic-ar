<script setup>
    import { Head, Link } from '@inertiajs/inertia-vue3';
    import AppLayout from '@/Layouts/AppLayout.vue';
    import Create from '@/Pages/Objectives/Create.vue';
    import Show from '@/Pages/Objectives/Show.vue';
</script>
<template>
    <AppLayout title="Objetivos">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                <span class="text-gray-500">Objetivos de lectura</span>
            </h2>
        </template>        
        <select v-model="selected" v-on:change="changed">
            <option disabled value="">Seleccione un objetivo</option>
            <option v-for="objective in objectives" :key="objective.id" :value="objective.id">{{objective.name}}</option>
        </select>
        <button v-on:click="createNew" class="bg-violet-600 hover:bg-violet-700 text-white font-bold py-2 px-4 rounded m-2">Nuevo Objetivo</button>
        <!-- {{objectives}} -->
        <Show :name="oname" :volLeer="volLeer" :volLeyendo="volLeyendo" :volLeido="volLeido" :selected="selected"/>
        <Create :modal="modal" @close="close"/>
    </AppLayout>
</template>
<script>
import axios from 'axios'
export default {
    props:['objectives'],
    data(){
        return{
            modal:false,
            selected:"",
            oname:"",
            oprogress:"",
            ostatus:"",
            osteps:"",
            volLeer:[],
            volLeyendo:[],
            volLeido:[]
        }
    },
    methods:{
        createNew(){
            this.modal=true;
        },
        close(val){
            this.modal=val;
        },
        changed(){
            axios.get('/objectives-show',{params:{id:this.selected}}).then(response=>{
                //console.log(response.data.porleer);
                this.oname=response.data.name;
                this.oprogress=response.data.progress;
                this.ostatus=response.data.status;
                this.osteps=response.data.steps;
                this.volLeer=response.data.porleer;
                this.volLeyendo=response.data.leyendo;
                this.volLeido=response.data.leido;
                })
            // console.log(this.selected)
        }
    }
}
</script>