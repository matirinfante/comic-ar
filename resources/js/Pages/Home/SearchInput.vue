<template>
    <div>
        <VueMultiselect
            v-model="value"
            :options="options"
            :close-on-select="true"
            :clear-on-select="false"
            placeholder="Busca un cómic..."
            label="title"
            track-by="id"
            :show-no-options="false"
            :loading="isLoading"
            :internal-search="false"
            @search-change="onSearchChange"
            @select="onSelect"
            :select-label="selectLabel"
            @close="onClose"
        >
            <template v-slot:noResult>
                <span>No se han encontrado resultados</span>
            </template>
        </VueMultiselect>
    </div>
</template>

<script>
import VueMultiselect from 'vue-multiselect'
import axios from "axios";

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
    methods: {
        onSearchChange(term) {
            this.options = []
            this.isLoading = true
            if (term.length > 2) {
                axios.get('/search', {params: {query: term}}).then(response => {
                    this.options = response.data;
                    //console.log(response.data)
                    this.isLoading = false
                });
            }
        },
        onSelect(selected) {
            this.$inertia.get('/editions/' + selected.id);
        },
        onClose(value) {
            this.isLoading = false
        }
    }
}
</script>

<style src="vue-multiselect/dist/vue-multiselect.css"></style>
