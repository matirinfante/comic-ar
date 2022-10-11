<template>
    <transition enter-active-class="ease-out duration-300" enter-class="opacity-0" enter-to-class="opacity-100" leave-active-class="ease-in duration-200" leave-class="opacity-100" leave-to-class="opacity-0">
        <div class="relative z-10" aria-labelledby="modal-title" role="dialog" aria-modal="true" v-show="modal">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>

        <div class="fixed inset-0 z-10 overflow-y-auto">
            <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">

            <transition enter-active-class="ease-out duration-300" enter-class="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" enter-to-class="opacity-100 translate-y-0 sm:scale-100" leave-active-class="ease-in duration-200" leave-class="opacity-100 translate-y-0 sm:scale-100" leave-to-class="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                <div class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-fit sm:max-w-lg pr-5">
                    <div class="pt-3 sm:flex sm:flex-row-reverse">
                        <button v-on:click="close" type="button" class="mt-3 inline-flex w-full rounded-md bg-white text-base font-medium text-gray-700 shadow-sm sm:mt-0 sm:ml-3 sm:w-auto ">&#10060;</button>
                    </div>
                    <div class="bg-white pb-4 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                <h3 class="text-lg font-semibold leading-6 text-gray-900" id="modal-title">Datos de Objetivo</h3>
                                <div class="mt-2">
                                <form v-on:submit.prevent="submitForm">
                                <div>
                                    <label for="name">Nombre:</label>
                                    <input v-model="name" id="name" type="text" class="w-full border border-gray-300 px-3 py-2 rounded-lg shadow-sm focus:ring-1 focus:ring-indigo-500" required>
                                </div>
                                <div>
                                    <label for="days">Dias</label>
                                    <input v-model="days" id="days" type="text" class="w-full border border-gray-300 px-3 py-2 rounded-lg shadow-sm focus:ring-1 focus:ring-indigo-500">
                                </div>
                                <div class="mt-2">
                                    <label class="typo__label">Tomos a leer</label>
                                    <Multiselect
                                        v-model="value"
                                        :options="options"
                                        :multiple="true"
                                        :close-on-select="false"
                                        :clear-on-select="false"
                                        :preserve-search="true"
                                        placeholder="Busca un cómic..."
                                        label="title"
                                        track-by="id"
                                        open-direction="bottom"
                                        :preselect-first="true"
                                        :show-no-options="false"
                                        :searchable="true"
                                        :loading="isLoading"
                                        :internal-search="false"
                                        :options-limit="300"
                                        :limit="5"
                                        :max-height="600"
                                        :show-no-results="false"
                                        :hide-selected="true"
                                        @search-change="onSearchChange"
                                        @select="onSelect"
                                        @close="onClose"
        >
                                        <template v-slot:noResult>
                                            <span>No se han encontrado resultados</span>
                                        </template>
                                        
                                    </Multiselect>
                                </div>
                                
                                <button v-on:click="send" type="submit" class="mt-5 rounded-md border border-transparent bg-green-600 px-4 py-2 text-base font-medium text-white shadow-sm hover:bg-violet-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2  sm:w-auto sm:text-sm">Empezar</button>

                                </form>
                                </div>
                            </div>
                        </div>
                    </div>
                 
                </div>
            </transition>
            </div>
        </div>
        </div>
    </transition>
</template>
<style src="vue-multiselect/dist/vue-multiselect.css"></style>   
<script>
import Multiselect from 'vue-multiselect'
import axios from 'axios'
export default {
    props:['modal'],
    components: {
    Multiselect
  },
  data () {
    return {
      value: null,
      options: [],
      isLoading: false,
      days:"",
      name:""
    }
  },
  methods:{
    onSearchChange(term) {
            this.options = []
            this.isLoading = true
            if (term.length > 2) {
                axios.get('/searchObj', {params: {query: term}}).then(response => {
                    this.options = response.data;
                    this.isLoading = false
                });
            }
    },
    onSelect(selected) {
            // this.$inertia.get('/editions/' + selected.id);
    },
    onClose(value) {
            this.isLoading = false
    },
    close(){
        this.$emit('close',false);
    },
    updt(data){
        this.$emit('updt',data)
    },
    send(){
        axios.post('/objectives',{
            name:this.name,
            days:this.days,
            volumes:this.value
        }).then(response=>{ this.close(); this.updt(response.data)});
    }
  }
}
</script>