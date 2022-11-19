<script setup>
import { Head, Link } from '@inertiajs/inertia-vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import SectionBorder from '@/Components/SectionBorder.vue';
import Pagination from '../../Components/Pagination.vue';

defineProps({
    editions: Object,
})
</script>

<template>
    <AppLayout title="Ediciones">
        <template #header>
            <span class="sr-only">Esta es la vista de ediciones</span>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Ediciones
            </h2>
        </template>

        <div>
            <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
                <!-- CONTENIDO CENTRAL -->
                <div class="flex flex-col md:flex-row justify-between mx-6 mb-5">
                    <!-- Buscador -->
                    <div class="md:w-6/12 px-4">
                        <!-- Buscar... -->
                        <VueMultiselect v-model="value" :options="options" :close-on-select="true" :clear-on-select="false"
                        placeholder="Busca una edición..." label="title" track-by="id" :show-no-options="false"
                        :loading="isLoading" :internal-search="false" @search-change="onSearchChange" @select="onSelect"
                        :select-label="selectLabel" @close="onClose">
                        <template v-slot:noResult>
                            <span>No se han encontrado resultados</span>
                        </template>
                    </VueMultiselect>
                    </div>
                    <!-- Botón de creación -->
                    <div class="">
                        <Link :href="route('editions.create')" class="mt-6 text-center w-full md:mt-0 inline-block px-6 my-auto py-2 border-2 border-purple-600 text-purple-600 font-medium text-xs leading-tight uppercase rounded-full hover:bg-purple-600 hover:text-white focus:outline-none focus:ring-0 transition duration-150 ease-in-out">Añadir Nueva
                        Edición
                        </Link>
                    </div>
                </div>
                <SectionBorder/>
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6">
                    <div v-for="edition in editions.data" :key="edition.id"
                        class="w-50 h-60 mx-auto mb-20 md:mb-14 shadow-md hover:shadow-indigo-400 relative">
                        <Link :href="route('editions.show', edition)">

                        <img class="w-full h-60" :src="edition.cover" :alt="edition.title" />
                        <div
                            class="absolute inset-0 z-10 text-white text-center flex flex-col items-center justify-center opacity-0 bg-gray-900 hover:opacity-100 bg-opacity-50 duration-300">
                            {{edition.title}}
                        </div>
                        </Link>
                    </div>
                </div>
                <div class="p-2">
                    <Pagination :links="editions.links" />
                </div>
            </div>
        </div>
    </AppLayout>
</template>
<style src="vue-multiselect/dist/vue-multiselect.css"></style>
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
                axios.get('/search', {params: {query: term}}).then(response => {
                    this.options = response.data;
                    // console.log(response.data)
                    this.isLoading = false
                });
            }
        },
        onSelect(selected) {
            this.$inertia.get('/editions/' + selected.id);
        },
        onClose(value) {
            this.isLoading = false
        },
        badge(){
            axios.get('/badgeCheck',{params:{badge:'firstEdition'}}).then(response=>{
                if (!response.data){
                    toastr.options.positionClass="toast-bottom-right";
                    toastr.options.progressBar = true;
                    toastr.warning('Insignia desbloqueada');    
                }
            });
        }
    }
}
</script>
