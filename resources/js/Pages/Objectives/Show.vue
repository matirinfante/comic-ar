<template>
  <div class="grid grid-cols-3 bg-purple-100 divide-x-2 divide-purple-400 py-3">
    <div>
      <h3 class="text-center pb-1">Por Leer</h3>
      <div class="flex justify-center">
      <draggable
        class="w-32 bg-white rounded-lg border border-gray-200 dark:bg-gray-700 dark:border-gray-600"
        :list="volLeer"
        group="people"
        @change="log"
        itemKey="coverImage"
      >
        <template #item="{ element}">
          <div class="py-1 px-2 w-fit border-b border-gray-200 dark:border-gray-600"><img :src="element.coverImage" class="h-46"></div>
        </template>
      </draggable>
      </div>
    </div>

    <div>
      <h3 class="text-center pb-1">Leyendo</h3>
      <div class="flex justify-center">
      <draggable
        class="w-32 bg-white rounded-lg border border-gray-200 dark:bg-gray-700 dark:border-gray-600"
        :list="volLeyendo"
        group="people"
        @change="log"
        itemKey="coverImage"
      >
        <template #item="{ element}">
          <div class="py-1 px-2 w-fit border-b border-gray-200 dark:border-gray-600"><img :src="element.coverImage" class="h-46"></div>
        </template>
      </draggable>
      </div>
    </div>

    <div class="">
      <h3 class="text-center pb-1">Leido</h3>
      <div class="flex justify-center">
      <draggable
        class="w-32 bg-white rounded-lg border border-gray-200 dark:bg-gray-700 dark:border-gray-600"
        :list="volLeido"
        group="people"
        @change="log"
        itemKey="title"
      >
        <template #item="{ element}">
          <div class="py-1 px-2 w-fit border-b border-gray-200 dark:border-gray-600"><img :src="element.coverImage" class="h-46"></div>
        </template>
      </draggable>
      </div>
    </div>
  </div>
</template>
<script>
import axios from 'axios';
import draggable from "vuedraggable";
export default {
    name: "three-lists",
  display: "Three Lists",
  order: 1,
  components: {
    draggable,
  },
  props: ["name", "volLeer","volLeyendo","volLeido","selected"],
  data() {
    return {
      selection: this.selected,
      leer:this.volLeer,
      leyendo:this.volLeyendo,
      leido:this.volLeido,
      once:true,  //to avoid log function from being called twice
    };
  },
  methods: {
    log: function(evt) {
      if (this.once){
        axios.post('/objectives-update',{
          leer:this.volLeer,
          leyendo:this.volLeyendo,
          leido:this.volLeido,
          id:this.selected
        }).then(response=>{
          var cantLeer= this.volLeer.length;
          var cantLeyendo= this.volLeyendo.length;
          var cantLeido= this.volLeido.length;
          axios.post('/objectives-calculate',{
            leer:cantLeer,
            leyendo:cantLeyendo,
            leido:cantLeido,
            id:this.selected
          }).then(response=>{this.updateProg(response.data)});
        })
      }
      this.once=(!this.once);
    },
    updateProg(val){
      this.$emit('updateProg',val);
    }
  },
};
</script>