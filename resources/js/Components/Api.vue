<script setup>
import Modalapi from '@/Components/Modalapi.vue';
</script>
<template>
<div class="m-5">
    
    <input  v-model="query" v-on:keyup="borrar" placeholder="Título o ISBN" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline mb-3">
    <div class="flex justify-between">
        <div>
            <button v-on:click="fetch" class="bg-cyan-600 hover:bg-cyan-700 text-white font-bold py-2 px-4 rounded m-2">Buscar por Nombre</button>
            <button v-on:click="isbn" class="bg-cyan-600 hover:bg-cyan-700 text-white font-bold py-2 px-4 rounded m-2">Buscar por ISBN</button>
        </div>
        <div>
            <button v-on:click="manual" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded m-2">Carga Manual</button>
        </div>
    </div>
    <div>
        <h2 class="text-lg" v-show="mostrar">Resultados para {{query}}:</h2>
        <h4 class="text-sm" v-show="mostrar">Coincidencias: {{cantidad}}</h4>
        <hr/>
        <div class="flex grid grid-cols-3 bg-cyan-50">
            <div v-show="verVol" v-for="volume in volumes" :key="volume.id" class="flex grid grid-cols-2 p-5 border-cyan-200 border-solid border-b">
                <div>
                    <img :src="'http://books.google.com/books/content?id='+volume.id+'&printsec=frontcover&img=1&zoom=1&source=gbs_api'">
                </div>
                <div>
                    <h3 class="font-bold">{{volume.volumeInfo.title}}</h3>                    
                    <p>Autor/es {{volume.volumeInfo.authors}}</p>
                    <p v-if="!(volume.volumeInfo.industryIdentifiers==null)">ISBN: {{volume.volumeInfo.industryIdentifiers[0].identifier}}</p>
                    <button v-on:click="choosed(volume.id)" class="bg-green-600 hover:bg-violet-700 text-white font-bold py-2 px-4 rounded">Agregar a coleccion</button>
                </div> 
            </div>
        </div>
        
    </div>

    <Modalapi :modal="modal" :editionid="editionid" :ftitle="ftitle" :fisbn="fisbn" :freview="freview" :fimg="fimg" @close="closeModal"/>
    
</div>
</template>



<script>
import axios from 'axios'
export default {
    name:"App",
    data(){
        return{
            query:"",
            mostrar:false,
            volumes:null,
            verVol:true,
            cantidad:null,
            ftitle:"",
            fisbn:"",
            fauthors:"",
            fimg:null,
            freview:"",
            modal:false,
            editionid:null
        }
    },
    mounted(){
        const url = window.location.href;
        const lastParam = url.split("id=").slice(-1)[0];
        this.editionid=lastParam;
    },
    methods:{
        fetch(){
            var url='https://www.googleapis.com/books/v1/volumes?q='+this.query+'&maxResults=40';
            axios.get(url).then(response=>{
                this.mostrar=true;
                this.verVol=true;
                this.cantidad=response.data.items.length;
                this.volumes=response.data.items;
            }).catch(e=>(console.log(e)))
        },
        isbn(){
            var url='https://www.googleapis.com/books/v1/volumes?q=isbn:'+this.query+'&maxResults=40';
            axios.get(url).then(response=>{
                this.mostrar=true;
                this.verVol=true;
                this.cantidad=response.data.items.length;
                this.volumes=response.data.items;
            }).catch(e=>(console.log(e)))
        },
        borrar(){
            this.mostrar=false;
            this.verVol=false;
        },
        choosed(id){
            var url='https://www.googleapis.com/books/v1/volumes/'+id;
            axios.get(url).then(response=>{
                this.ftitle=response.data.volumeInfo.title;
                if (!(response.data.volumeInfo.industryIdentifiers==null)){
                    this.fisbn=response.data.volumeInfo.industryIdentifiers[0].identifier;
                }
                if(!(response.data.volumeInfo.description==null)){
                    this.freview=response.data.volumeInfo.description;
                }
                
                this.fauthors=response.data.volumeInfo.authors;
                this.fimg="http://books.google.com/books/content?id="+id+"&printsec=frontcover&img=1&zoom=1&source=gbs_api";
                this.modal=true;
            }).catch(e=>(console.log(e)))
        },
        closeModal(val){
            this.modal=val;
            this.freview="";
            this.title="";
            this.fisbn="";
            this.fimg="";
        },
        manual(){
            this.modal=true;
        }
        
    }
}
</script>