<template>
<div class="m-5">
    
    <input  v-model="query" v-on:keyup="borrar" placeholder="metele papi" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
    <button v-on:click="fetch" class="bg-orange-600 hover:bg-violet-700 text-white font-bold py-2 px-4 rounded m-2">Buscar por Nombre</button>
    <button v-on:click="isbn" class="bg-green-600 hover:bg-violet-700 text-white font-bold py-2 px-4 rounded m-2">Buscar por ISBN</button>
    <div>
        <h2 class="text-lg" v-show="mostrar">Resultados para {{query}}:</h2>
        <h4 class="text-sm" v-show="mostrar">Coincidencias: {{cantidad}}</h4>
        <hr/>
        <div class="flex grid grid-cols-3 bg-cyan-50 p-2">
            <div v-show="verVol" v-for="volume in volumes" :key="volume.id" class="flex grid grid-cols-2 p-5 border-cyan-200 border-solid border-b">
                <div>
                    <img :src="'http://books.google.com/books/content?id='+volume.id+'&printsec=frontcover&img=1&zoom=1&source=gbs_api'">
                </div>
                <div>
                    <h3 class="font-bold">{{volume.volumeInfo.title}}</h3>                    
                    <p>Autores {{volume.volumeInfo.authors}}</p>
                    <p v-if="!(volume.volumeInfo.industryIdentifiers==null)">ISBN: {{volume.volumeInfo.industryIdentifiers[0].identifier}}</p>
                    <button v-on:click="choosed(volume.id)" class="bg-green-600 hover:bg-violet-700 text-white font-bold py-2 px-4 rounded">Agregar a coleccion</button>
                </div> 
            </div>
        </div>
        
    </div>
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
            fimg:"",
        }
    },
    methods:{
        fetch(){
            var url='https://www.googleapis.com/books/v1/volumes?q='+this.query+'&maxResults=40';
            axios.get(url).then(response=>{
                this.mostrar=true;
                this.verVol=true;
                this.cantidad=response.data.items.length;
                //console.log(response.data.items.length);
                this.volumes=response.data.items;
                //console.log(this.volumes);
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
                this.fisbn=response.data.volumeInfo.industryIdentifiers[0].identifier;
                this.fauthors=response.data.volumeInfo.authors;
                this.fimg="http://books.google.com/books/content?id="+id+"&printsec=frontcover&img=1&zoom=1&source=gbs_api";
                //console.log('Nombre: '+this.ftitle+' ISBN: '+this.fisbn+' Autores: '+this.fauthors+' Img: '+this.fimg);
                alert('Nombre: '+this.ftitle+' ISBN: '+this.fisbn+' Autores: '+this.fauthors+' Img: '+this.fimg);
            }).catch(e=>(console.log(e)))
        }
        
    }
}
</script>