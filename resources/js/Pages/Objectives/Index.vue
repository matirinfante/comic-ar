<script setup>
import {Head, Link} from '@inertiajs/inertia-vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import Create from '@/Pages/Objectives/Create.vue';
import Show from '@/Pages/Objectives/Show.vue';
import Notification from '@/Pages/Objectives/Notification.vue';

</script>
<template>
    <AppLayout title="Objetivos">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                <!-- <span class="text-gray-500"> -->
                Objetivos de lectura
                <!-- </span> -->
            </h2>
        </template>
        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
            <div class="flex justify-between mt-3">
                <div class="pl-3">
                    <select v-model="selected" v-on:change="changed" class="rounded">
                        <option disabled value="noselect">Seleccione un objetivo</option>
                        <option v-for="objective in objetivos" :key="objective.id" :value="objective.id">
                            {{ objective.name }}
                        </option>
                    </select>
                    <button v-show="cargar" v-on:click="erase"
                            class="bg-orange-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded m-2">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                             stroke="currentColor" class="w-6 h-6 inline">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/>
                        </svg>
                        Eliminar
                        Actual
                    </button>
                </div>
                <div>
                    <button v-on:click="createNew"
                            class="bg-violet-600 hover:bg-violet-700 text-white font-bold py-2 px-4 rounded m-2">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                             stroke="currentColor" class="w-6 h-6 inline">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m6-6H6"/>
                        </svg>
                        Nuevo
                        Objetivo
                    </button>
                </div>
            </div>
        </div>
        <div v-show="cargar" class="text-center mb-4">
            <ve-progress :progress="progress" color="purple" fontSize="2rem" legendClass="pb-10"></ve-progress>
        </div>

        <Notification :messageon="messageon" :message="message" @closenotif="closenotif"/>
        <Show v-show="cargar" :name="oname" :volLeer="volLeer" :volLeyendo="volLeyendo" :volLeido="volLeido"
              :selected="selected" @updateProg="updateProg"/>
        <Create :modal="modal" @close="close" @updt="updt"/>
    </AppLayout>
</template>
<style>
span.ep-legend--value__counter:after {
    content: "%";
}
</style>
<script>
import {VeProgress} from "vue-ellipse-progress";
import axios from 'axios'

export default {
    props: ['objectives'],
    data() {
        return {
            objetivos: this.objectives,
            modal: false,
            selected: "noselect",
            oname: "",
            progress: 0,
            days: "",
            volLeer: [],
            volLeyendo: [],
            volLeido: [],
            cargar: false,
            message: [],
            messageon: false
        }
    },
    mounted() {
        var option = 2;
        axios.get('/objnotifications-ask', {params: {option: option}}).then(response => {
            if (response.data != "") {
                this.message = response.data.split('</br>');
                this.messageon = true;
            }
        });
    },
    methods: {
        createNew() {
            this.modal = true;
        },
        close(val) {
            this.modal = val;
        },
        updt(data) {
            this.objetivos = data;
            this.selected = data[data.length - 1]['id'];
            this.changed();
        },
        changed() {
            this.cargar = true;
            axios.get('/objectives-show', {params: {id: this.selected}}).then(response => {
                this.oname = response.data.name;
                this.progress = response.data.progress;
                this.days = response.data.days;
                this.volLeer = response.data.porleer;
                this.volLeyendo = response.data.leyendo;
                this.volLeido = response.data.leido;
            })
        },
        updateProg(val) {
            this.progress = Math.round(val);
        },
        erase() {
            axios.delete('/objectives/' + this.selected)
                .then(response => {
                    this.objetivos = response.data;
                    this.cargar = false;
                    this.selected = 'noselect'
                })
        },
        closenotif(val) {
            this.messageon = val;
            axios.get('/objnotifications-update').then(response => {
            });
        },
    }
}
</script>
