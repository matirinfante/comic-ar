<script setup>
import Modalapi from '@/Components/Modalapi.vue';
import NotFound from '@/Components/NotFound.vue';
</script>
<template>
    <div class="m-5">
        <div class="bg-blue-200 border-blue-300 shadow-sm text-blue-600 rounded px-4 py-3 mb-5" role="alert">
            <p class="text-xl font-bold">¿Cómo añado un volumen a esta edición?</p>
            <p class="text-md">Puedes buscar el titulo del volumen o ingresar el ISBN (sin guiones). Si no encuentras lo que buscas,
                también puedes cargarlo manualmente</p>
        </div>
        <div>
            <input v-model="query" v-on:keyup="borrar" placeholder="Título o ISBN"
                   class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline mb-3">
            <div v-if="validated && errors"
                 class="flex p-4 mb-4 text-sm text-red-700 bg-red-100 rounded-lg dark:bg-red-200 dark:text-red-800"
                 role="alert">
                <svg aria-hidden="true" class="flex-shrink-0 inline w-5 h-5 mr-3" fill="currentColor"
                     viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd"
                          d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                          clip-rule="evenodd"></path>
                </svg>
                <span class="sr-only">Error</span>
                <div>
                    <span class="font-medium">Compruebe los siguiente:</span>
                    <ul class="mt-1.5 ml-4 text-red-700 list-disc list-inside">
                        <li v-if="invalidISBN">Ha ingresado un ISBN válido</li>
                        <li v-if="invalidInput">Su búsqueda contiene al menos una letra</li>
                    </ul>
                </div>
            </div>
            <div v-if="!invalidISBN && validated" id="alert-3"
                 class="flex p-4 mb-4 bg-green-100 rounded-lg dark:bg-green-200"
                 role="alert">
                <svg aria-hidden="true" class="flex-shrink-0 w-5 h-5 text-green-700 dark:text-green-800"
                     fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd"
                          d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                          clip-rule="evenodd"></path>
                </svg>
                <span class="sr-only">Info</span>
                <div class="ml-3 text-sm font-medium text-green-700 dark:text-green-800">
                    Su ISBN es válido!
                </div>
            </div>
            <!--            <p v-if="invalidInput" class="text-red-500">Debe ingresar el título del volumen o el ISBN</p>-->
            <!--            <p v-if="invalidISBN && validated">Ingrese un ISBN válido</p>-->
            <div v-if="isLoading" class="transition-opacity duration-1000" role="status">
                <svg class="inline mr-2 w-8 h-8 text-gray-200 animate-spin dark:text-gray-600 fill-purple-600"
                     viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
                        fill="currentColor"/>
                    <path
                        d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
                        fill="currentFill"/>
                </svg>
                <span class="sr-only">Loading...</span>
            </div>
        </div>

        <div class="flex justify-center">
            <div>
                <button v-on:click="fetch"
                        class="bg-cyan-600 hover:bg-cyan-700 text-white font-bold py-2 px-4 rounded m-2">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                         class="w-6 h-6 inline">
                        <path fill-rule="evenodd"
                              d="M10.5 3.75a6.75 6.75 0 100 13.5 6.75 6.75 0 000-13.5zM2.25 10.5a8.25 8.25 0 1114.59 5.28l4.69 4.69a.75.75 0 11-1.06 1.06l-4.69-4.69A8.25 8.25 0 012.25 10.5z"
                              clip-rule="evenodd"/>
                    </svg>
                    Buscar por
                    Nombre
                </button>
                <button v-on:click="isbn"
                        class="bg-cyan-600 text-white font-bold py-2 px-4 rounded m-2"
                        :disabled="invalidISBN"
                        :class="invalidISBN?'hover:none disabled:opacity-50':'hover:bg-cyan-700'">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                         class="w-6 h-6 inline">
                        <path fill-rule="evenodd"
                              d="M10.5 3.75a6.75 6.75 0 100 13.5 6.75 6.75 0 000-13.5zM2.25 10.5a8.25 8.25 0 1114.59 5.28l4.69 4.69a.75.75 0 11-1.06 1.06l-4.69-4.69A8.25 8.25 0 012.25 10.5z"
                              clip-rule="evenodd"/>
                    </svg>
                    Buscar por ISBN
                </button>
            </div>
            <div>
                <button v-on:click="manual"
                        class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded m-2">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                         stroke="currentColor" class="w-6 h-6 inline">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M12 16.5V9.75m0 0l3 3m-3-3l-3 3M6.75 19.5a4.5 4.5 0 01-1.41-8.775 5.25 5.25 0 0110.233-2.33 3 3 0 013.758 3.848A3.752 3.752 0 0118 19.5H6.75z"/>
                    </svg>
                    Carga Manual
                </button>
            </div>
        </div>
        <div>
            <h2 class="text-lg" v-show="mostrar">Resultados para {{ query }}:</h2>
            <h4 class="text-sm" v-show="mostrar">Coincidencias: {{ cantidad }}</h4>
            <hr/>
            <div class="flex grid grid-cols-3 bg-cyan-50">
                <div v-show="verVol" v-for="volume in volumes" :key="volume.id"
                     class="flex grid grid-cols-2 p-5 border-cyan-200 border-solid border-b">
                    <div>
                        <img
                            :src="'http://books.google.com/books/content?id='+volume.id+'&printsec=frontcover&img=1&zoom=1&source=gbs_api'">
                    </div>
                    <div>
                        <h3 class="font-bold">{{ volume.volumeInfo.title }}</h3>
                        <p>Autor/es {{ volume.volumeInfo.authors }}</p>
                        <p v-if="!(volume.volumeInfo.industryIdentifiers==null)">ISBN:
                            {{ volume.volumeInfo.industryIdentifiers[0].identifier }}</p>
                        <button v-on:click="choosed(volume.id)"
                                class="bg-green-600 hover:bg-violet-700 text-white font-bold py-2 px-4 rounded">Agregar
                            a coleccion
                        </button>
                    </div>
                </div>
            </div>

            <!-- SI NO ENCUENTRA RESULTADOS EN LA BUSQUEDA -->
            <div v-if="noData" class="mt-5">
                <div class="flex justify-center mb-5">
                    <p  class="font-bold text-xl mb-3 ml-3 mt-2 text-black px-2 border-double border-b-4 border-violet-700 drop-shadow-md">No se encontraron resultados</p>
                </div>
                <div class="flex justify-center">
                    <NotFound class="w-1/2 h-fit"/>
                </div>
            </div>
        </div>

        <Modalapi :modal="modal" :editionid="editionid" :ftitle="ftitle" @changeTitle="cTitle" :fisbn="fisbn" @changeIsbn="cIsbn" :freview="freview" @changeReview="cReview" :fimg="fimg" @changeImg="cImg"
                  @close="closeModal"/>

    </div>
</template>


<script>
import axios from 'axios'

export default {
    name: "App",
    data() {
        return {
            query: "",
            mostrar: false,
            noData:false,
            volumes: null,
            verVol: true,
            cantidad: null,
            ftitle: "",
            fisbn: "",
            fauthors: "",
            fimg: null,
            freview: "",
            modal: false,
            editionid: null,
            invalidInput: false,
            invalidISBN: false,
            validated: false,
            isLoading: false,
            errors: false
        }
    },
    mounted() {
        const url = window.location.href;
        const lastParam = url.split("id=").slice(-1)[0];
        this.editionid = lastParam;
    },
    methods: {
        fetch() {
            var url = 'https://www.googleapis.com/books/v1/volumes?q=' + this.query + '&maxResults=40';
            axios.get(url).then(response => {
                if(response.data.items!=null){
                    this.mostrar = true;
                    this.verVol = true;
                    this.cantidad = response.data.items.length;
                    this.volumes = response.data.items;                    
                }else{
                    this.noData=true;
                }                
            }).catch(e => (console.log(e)))
        },
        isbn() {
            var url = 'https://www.googleapis.com/books/v1/volumes?q=isbn:' + this.query + '&maxResults=40';
            axios.get(url).then(response => {
                if(response.data.items!=null){
                    this.mostrar = true;
                    this.verVol = true;
                    this.cantidad = response.data.items.length;
                    this.volumes = response.data.items;                    
                }else{
                    this.noData=true;
                }   
            }).catch(e => (console.log(e)))
        },
        borrar() {
            this.mostrar = false;
            this.verVol = false;
            this.noData=false;
        },
        choosed(id) {
            var url = 'https://www.googleapis.com/books/v1/volumes/' + id;
            axios.get(url).then(response => {
                this.ftitle = response.data.volumeInfo.title;
                if (!(response.data.volumeInfo.industryIdentifiers == null)) {
                    this.fisbn = response.data.volumeInfo.industryIdentifiers[0].identifier;
                }
                if (!(response.data.volumeInfo.description == null)) {
                    this.freview = response.data.volumeInfo.description;
                }

                this.fauthors = response.data.volumeInfo.authors;
                this.fimg = "http://books.google.com/books/content?id=" + id + "&printsec=frontcover&img=1&zoom=1&source=gbs_api";
                this.modal = true;
            }).catch(e => (console.log(e)))
        },
        closeModal(val) {
            this.modal = val;
            this.freview = "";
            this.title = "";
            this.fisbn = "";
            this.fimg = "";
        },
        manual() {
            this.modal = true;
        },
        checkISBN() {
            this.isLoading = true
            axios.get('/checkISBN', {
                params: {
                    isbn: this.query
                }
            }).then((response) => {
                this.isLoading = false
                this.invalidISBN = !response.data
                this.validated = true
                this.errors = false
            })
        },
        cTitle(value){
            this.ftitle=value;
        },
        cIsbn(value){
            this.fisbn=value;
        },
        cReview(value){
            this.freview=value;
        },
        cImg(value){
            this.fimg=value;
        }
    },
    computed: {
        invalidInput() {
            return this.invalidInput
        }
        ,
        invalidISBN() {
            if (this.query.length === 13 && !isNaN(this.query)) {
                this.checkISBN()
            } else if (this.query.length > 0 && !isNaN(this.query)) {
                this.invalidISBN = true
                this.errors = true
            } else {
                this.invalidISBN = true
                this.errors = false
                this.validated = false
            }
            return this.invalidISBN
        },
        validated() {
            return this.validated
        },
        isLoading() {
            return this.isLoading
        },
        errors() {
            return this.errors
        }
    }
}
</script>
