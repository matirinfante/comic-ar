<style src="vue-multiselect/dist/vue-multiselect.css"></style>
<script setup>
import { Link } from '@inertiajs/inertia-vue3';
import { ref } from 'vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import SectionBorder from '@/Components/SectionBorder.vue';


const props = defineProps({
    booklists: Object,
})

const filteredBookLists = ref(props.booklists);

const filterBookLists = (id) => {
    if (id === "all") {
        filteredBookLists.value = props.booklists;
    }
    if (id === "guide") {
        filteredBookLists.value = props.booklists.filter(booklist => {
            return booklist.classification === "Guía de lectura";
        });
    }
    if (id === "crossover") {
        filteredBookLists.value = props.booklists.filter(booklist => {
            return booklist.classification === "Crossover";
        });
    }
    if (id === "personal") {
        filteredBookLists.value = props.booklists.filter(booklist => {
            return booklist.classification === "Personal";
        });
    }
    if (id === "myBooklist") {
        filteredBookLists.value = props.booklists.filter(booklist => {
            return booklist.actualUsr === "y";
        });
    }
};
</script>

<template>
    <AppLayout title="Listas">
        <template #header>
            <span class="sr-only">Esta es la vista de Listas de comics</span>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Listas
            </h2>
        </template>

        <div>
            <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
                <div class="bg-blue-200 border-blue-300 shadow-sm text-blue-600 rounded px-4 py-3 mb-5" role="alert">
                    <p class="text-xl font-bold">¿Qué son las listas?</p>
                    <p class="text-md">El mundo de los cómics puede llegar a ser tan caótico que se necesitan de guías para no perderse en el orden de lectura. Estas listas también pueden ser creadas con tus propias preferencias y podrán ser vistas por el resto de la comunidad.</p>
                </div>
                <!-- CONTENIDO CENTRAL -->
                <!-- Buscador -->
                <div class="md:w-6/12 px-4 py-2">
                    <!-- Buscar... -->
                    <VueMultiselect v-model="value" :options="options" :close-on-select="true" :clear-on-select="false"
                        placeholder="Busca una lista..." label="title" track-by="id" :show-no-options="false"
                        :loading="isLoading" :internal-search="false" @search-change="onSearchChange" @select="onSelect"
                        :select-label="selectLabel" @close="onClose">
                        <template v-slot:noResult>
                            <span>No se han encontrado resultados</span>
                        </template>
                    </VueMultiselect>
                </div>

                <div class="flex flex-col md:flex-row justify-between mx-6 mb-5 mt-4">
                    <ul class="flex flex-wrap text-sm font-medium text-center">
                        <li class="mr-2">
                            <button @click="filterBookLists('all')" type="button"
                                class="text-white bg-gradient-to-br from-purple-600 to-blue-500 hover:bg-gradient-to-bl focus:ring-2 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 font-medium rounded-lg text-xs px-5 py-1 text-center mr-2 mb-2">Todo</button>
                        </li>
                        <li class="mr-2">
                            <button @click="filterBookLists('guide')" type="button"
                                class="text-white bg-gradient-to-r from-cyan-500 to-blue-500 hover:bg-gradient-to-bl focus:ring-2 focus:outline-none focus:ring-cyan-300 dark:focus:ring-cyan-800 font-medium rounded-lg text-xs px-5 py-1 text-center mr-2 mb-2">Guía
                                de Lectura</button>
                        </li>
                        <li class="mr-2">
                            <button @click="filterBookLists('crossover')" type="button"
                                class="text-white bg-gradient-to-br from-green-400 to-blue-600 hover:bg-gradient-to-bl focus:ring-2 focus:outline-none focus:ring-green-200 dark:focus:ring-green-800 font-medium rounded-lg text-xs px-5 py-1 text-center mr-2 mb-2">Crossover</button>
                        </li>
                        <li class="mr-2">
                            <button @click="filterBookLists('personal')" type="button"
                                class="text-white bg-gradient-to-r from-purple-500 to-pink-500 hover:bg-gradient-to-l focus:ring-2 focus:outline-none focus:ring-purple-200 dark:focus:ring-purple-800 font-medium rounded-lg text-xs px-5 py-1 text-center mr-2 mb-2">Personal</button>
                        </li>
                        <li class="mr-2">
                            <button @click="filterBookLists('myBooklist')" type="button"
                                class="text-white bg-gradient-to-r from-pink-500 to-orange-400 hover:bg-gradient-to-bl focus:ring-2 focus:outline-none focus:ring-pink-200 dark:focus:ring-pink-800 font-medium rounded-lg text-xs px-5 py-1 text-center mr-2 mb-2">Mis listas</button>
                        </li>
                    </ul>

                    <!-- Botón de creación -->
                    <Link :href="route('booklists.create')"
                        class="mt-6 text-center md:mt-0 inline-block px-6 my-auto py-2 border-2 border-purple-600 text-purple-600 font-medium text-xs leading-tight uppercase rounded-full hover:bg-purple-600 hover:text-white focus:outline-none focus:ring-0 transition duration-150 ease-in-out">
                    Crear Lista
                    </Link>
                </div>
                <SectionBorder />

                <div v-for="book in filteredBookLists" :key="book.id">

                    <div
                        class="bg-white shadow-md mb-32 sm:mb-10 h-32 w-9/12 mx-auto border-2 border-t-gray-300 border-b-white hover:shadow-purple-200">
                        <Link :href="route('booklists.show', book)">
                        <div class="flex flex-wrap relative">
                            <!-- imagen -->
                            <div class="flex relative">
                                <div v-if="book['vol'][0] != null">
                                    <img class="relative object-cover h-32 z-40" :src="book['vol'][0]['coverImage']"
                                        :alt="book['vol'][0]['title']">
                                </div>
                                <div v-else>
                                    <img class="relative object-cover h-32 z-40" :src="'/assets/cover/default.png'"
                                        alt="Imagen de lista #1">
                                </div>

                                <div v-if="book['vol'][1] != null">
                                    <img class="absolute left-10 object-cover h-32 z-30"
                                        :src="book['vol'][1]['coverImage']" :alt="book['vol'][1]['title']">
                                </div>
                                <div v-else>
                                    <div class="absolute left-10 object-cover h-32 z-30 bg-gray-200 w-full"></div>
                                </div>

                                <div v-if="book['vol'][2] != null">
                                    <img class="absolute left-20 object-cover h-32 z-20"
                                        :src="book['vol'][2]['coverImage']" :alt="book['vol'][2]['title']">
                                </div>
                                <div v-else>
                                    <div class="absolute left-20 object-cover h-32 z-20 bg-gray-300 w-full"></div>
                                </div>

                                <div v-if="book['vol'][3] != null">
                                    <img class="absolute left-32 object-cover h-32 z-10"
                                        :src="book['vol'][3]['coverImage']" :alt="book['vol'][3]['title']">
                                </div>
                                <div v-else>
                                    <div
                                        class="absolute left-32 object-cover h-32 z-10 bg-gray-400 bg-opacity-60 w-full">
                                    </div>
                                </div>
                            </div>
                            <div class="absolute w-full pl-3 z-50 bg-gradient-to-r from-slate-400">
                                <span class="bg-white rounded-lg px-2">
                                    <span class="text-gray-500">{{ book.name }}</span>
                                    de <span class="text-orange-400">{{ book['usr'] }}</span>
                                </span>
                            </div>
                            <div
                                class="text-gray-600 bg-slate-200 truncate w-full ml-0 pl-2 py-2 sm:ml-40 sm:w-1/4 sm:py-10 md:w-1/2 sm:bg-opacity-0">
                                <span v-if="book.description != null">{{ book.description }}</span>
                                <span v-if="book.description == null"></span>
                                <br>
                                <span v-if="book['vol'].length == 0" class="text-gray-400">Sin Tomos</span>
                                <span v-if="book['vol'].length == 1" class="text-gray-400">1 Tomo</span>
                                <span v-if="book['vol'].length > 1" class="text-gray-400">{{ book['vol'].length }}
                                    Tomos</span>
                            </div>
                            <div class="absolute right-2 bottom-0">
                                <span v-if="book.classification == 'Guía de lectura'"
                                    class="px-2 text-xs text-white bg-gradient-to-r from-cyan-500 to-blue-500">{{ book.classification }}</span>
                                <span v-if="book.classification == 'Crossover'"
                                    class="px-2 text-xs text-white bg-gradient-to-br from-green-400 to-blue-600">{{ book.classification }}</span>
                                <span v-if="book.classification == 'Personal'"
                                    class="px-2 text-xs text-white bg-gradient-to-r from-purple-500 to-pink-500">{{ book.classification }}</span>
                            </div>
                        </div>
                        </Link>
                    </div>
                </div>


            </div>
        </div>
    </AppLayout>
</template>

<script>
import VueMultiselect from 'vue-multiselect'
import axios from "axios";
import toastr from 'toastr-comicar';
import 'toastr-comicar/build/toastr.min.css'; 
export default {
    components: {VueMultiselect},
    data() {
        return {
            value: null,
            options: [],
            isLoading: false,
            selectLabel: "Ver más"
        }
    },
    mounted(){
        setTimeout(() =>{
            this.badge();
        }, 10);
    },
    methods: {
        onSearchChange(term) {
            this.options = []
            this.isLoading = true
            if (term.length > 2) {
                axios.get('/searchList', {params: {query: term}}).then(response => {
                    this.options = response.data;
                    this.isLoading = false
                });
            } else if (term.length == 0) {
                this.isLoading = false
            }
        },
        onSelect(selected) {
            this.$inertia.get('/booklists/' + selected.id);
        },
        onClose(value) {
            this.isLoading = false
        },
        badge(){
            axios.get('/badgeCheck',{params:{badge:'Princesa de Temiscira'}}).then(response=>{
                if (response.data){
                    toastr.options.positionClass="toast-bottom-right";
                    toastr.options.progressBar = true;
                    toastr.info('Insignia desbloqueada');    
                }
            });
        }
    }
}
</script>

