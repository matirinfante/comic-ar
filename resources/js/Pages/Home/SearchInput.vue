<template>
    <div>
        <VueMultiselect
            v-model="value"
            :options="options"
            :close-on-select="true"
            :clear-on-select="false"
            placeholder="Busca un cómic..."
            label="name"
            track-by="name"
            :show-no-options="false"
        >
            <template v-slot:noResult>
                <span>No se han encontrado resultados</span>
            </template>
        </VueMultiselect>
    </div>
</template>

<script>
import VueMultiselect from 'vue-multiselect'

export default {
    components: {VueMultiselect},
    data() {
        return {
            value: [],
            selected: null,
            options: []
        }
    }
}
</script>

<style src="vue-multiselect/dist/vue-multiselect.css"></style>
