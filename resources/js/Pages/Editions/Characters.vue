<template>
    <div class="text-center font-bold text-2xl my-2">
        <h1>Personajes principales</h1>
    </div>
    <div class="flex space-x-4 my-5 justify-center">
        <div class="w-50 h-50 text-center" v-for="character in characters">
            <img class="w-40 h-40 object-cover rounded-full shadow-sm"
                 :src=character.image.medium_url alt="user image"/>
            <h3 class="font-bold my-2">{{ character.name }}</h3>
        </div>
    </div>
</template>

<script>
export default {
    name: "Characters",
    data() {
        return {
            characters: []
        }
    },
    mounted() {
        this.loadCharacters()
    },
    methods: {
        loadCharacters() {
            var incomingCharacters = this.$page.props.edition.characters
            if (incomingCharacters != null) {
                this.characters = JSON.parse(incomingCharacters)
            }
        }
    }
}
</script>

<style scoped>

</style>
