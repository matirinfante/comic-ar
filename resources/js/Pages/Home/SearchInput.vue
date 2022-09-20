<script>
import {ref} from 'vue'
import SearchInput from 'vue-search-input'
// Optionally import default styling
import 'vue-search-input/dist/styles.css'

const searchVal = ref('')

export default {
    data: function (){
        return {
            "type": "search",
            "modelValue": "",
            "wrapperClass": "search-input-wrapper",
            "searchIcon": false,
            "shortcutIcon": false,
            "clearIcon": true,
            "hideShortcutIconOnBlur": true,
            "clearOnEsc": false,
            "blurOnEsc": true,
            "selectOnFocus": false,
            "shortcutListenerEnabled": true,
            "shortcutKey": "/"
        }
    },
    components: {
        SearchInput
    },
    setup() {
        return {
            searchVal
        }
    }
}
</script>

<template>
    <SearchInput v-model="searchVal"/>
</template>



