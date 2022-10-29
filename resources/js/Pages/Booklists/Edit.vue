<script setup>
import { useForm } from '@inertiajs/inertia-vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import JetInput from '@/Components/Input.vue';
import JetInputError from '@/Components/InputError.vue';
import JetLabel from '@/Components/Label.vue';
import { Inertia } from '@inertiajs/inertia'

const props = defineProps({
    booklist: Object,
    volumes: Object,
});

const form = useForm({
    name: props.booklist?.name,
    classification: props.booklist?.classification,
    description: props.booklist?.description,
    value: props.volumes,
    user_id: ''
});

const submit = () => {
    Inertia.post(`/booklists/${props.booklist.id}`, {
        _method: "put",
        name: form.name,
        classification: form.classification,
        description: form.description,
        value: form.value,
    });
};
</script>

<template>
    <AppLayout title="Editar Lista">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                <span class="text-gray-500">Editar Lista</span>
            </h2>
        </template>

        <div>
            <div class="max-w-md mx-auto py-10 mt-10 sm:px-6 lg:px-8 bg-white shadow md:shadow-lg">
                <!-- CONTENIDO CENTRAL -->
                <form @submit.prevent="submit" class="p-4">
                    <!-- name -->
                    <div>
                        <JetLabel for="name" value="Nombre" />
                        <JetInput id="name" v-model="form.name" type="text" class="mt-1 block w-full" autofocus
                            required />
                        <JetInputError class="mt-2" :message="form.errors.name" />
                    </div>


                    <!-- description -->
                    <div class="mt-4">
                        <JetLabel for="description" value="Descripción (Opcional)" />
                        <textarea v-model="form.description" placeholder="Una descripción..." class="w-full"></textarea>
                        <JetInputError class="mt-2" :message="form.errors.description" />
                    </div>

                    <!-- classification -->
                    <div class="mt-4">
                        <JetLabel for="classification" value="Clasificación" />
                        <select id="classification" v-model="form.classification" required class="h-fit text-xs">
                            <option value="Guía de lectura">Guía de lectura</option>
                            <option value="Crossover">Crossover</option>
                            <option value="Personal">Personal</option>
                        </select>
                    </div>

                    <!-- add volumes -->
                    <div class="mt-4">
                        <JetLabel for="volumes" value="Tomo/s" />
                        <Multiselect v-model="form.value" :options="options" :multiple="true" :close-on-select="false"
                            :clear-on-select="false" :preserve-search="false" placeholder="Busca un cómic..."
                            label="title" track-by="id" open-direction="bottom" :preselect-first="true"
                            :show-no-options="false" :searchable="true" :loading="isLoading" :internal-search="false"
                            :options-limit="300" :limit="5" :max-height="600" :show-no-results="false"
                            :hide-selected="true" @search-change="onSearchChange" @select="onSelect" @close="onClose">
                            <template v-slot:noResult>
                                <span>No se han encontrado resultados</span>
                            </template>

                        </Multiselect>
                    </div>

                    <div class="flex items-center justify-end mt-8">
                        <button v-on:click="send" type="submit"
                            class="inline-flex items-center px-4 py-2 bg-indigo-500 hover:bg-indigo-700 text-white border border-transparent rounded-md font-semibold text-xs uppercase tracking-widest active:bg-white-300 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition">Actualizar</button>
                    </div>
                </form>
            </div>
        </div>
    </AppLayout>
</template>
<style src="vue-multiselect/dist/vue-multiselect.css">

</style>   
<script>
import Multiselect from 'vue-multiselect'
import axios from 'axios'
export default {
    components: {
        Multiselect
    },
    data() {
        return {
            value: null,
            options: [],
            isLoading: false,
            name: "",
            description: "",
            classification: "",
        }
    },
    methods: {
        onSearchChange(term) {
            this.options = []
            this.isLoading = true
            if (term.length > 2) {
                axios.get('/searchVol', { params: { query: term } }).then(response => {
                    this.options = response.data;
                    this.isLoading = false
                });
            } else if (term.length == 0) {
                this.isLoading = false
            }
        },
        onSelect(selected) {
            // this.$inertia.get('/editions/' + selected.id);
            this.isLoading = false
        },
        onClose() {
            this.isLoading = false
        },
        close() {
            this.$emit('close', false);
        },
        updt(data) {
            this.$emit('updt', data)
        },
    }
}
</script>
