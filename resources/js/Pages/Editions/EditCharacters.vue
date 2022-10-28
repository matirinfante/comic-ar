<template>
    <div>
        <label class="typo__label" for="ajax">Personajes principales</label>
        <multiselect v-model="selectedCharacters" id="ajax" label="name" track-by="id"
                     placeholder="Escribe para buscar"
                     open-direction="bottom" :options="characters" :multiple="true" :searchable="true"
                     :loading="isLoading" :internal-search="false" :clear-on-select="false" :close-on-select="false"
                     :options-limit="300" :max="3" :max-height="600" :show-no-results="false" :hide-selected="true"
                     @search-change="asyncFind" @close="sendSelected">
            <span slot="noResult">Oops! No elements found. Consider changing the search query.</span>
        </multiselect>
    </div>
</template>

<script>
import Multiselect from 'vue-multiselect'
import axios from "axios";

export default {
    components: {
        Multiselect
    },
    props: {
        selectedCharacters: Array
    },
    data() {
        return {
            characters: [],
            isLoading: false
        }
    },
    methods: {
        asyncFind(query) {
            this.isLoading = true
            axios.get('/characters', {
                params: {
                    partialText: query
                }
            })
                .then((response) => {
                    this.isLoading = false
                    this.characters = response.data.results
                })
        },
        sendSelected() {
            this.$emit('selected', this.selectedCharacters)
        }
    }
}
</script>

<style src="vue-multiselect/dist/vue-multiselect.css"></style>

