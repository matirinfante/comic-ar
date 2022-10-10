<script setup>
import rawDisplayer from '@/Pages/Objectives/rawDisplayer.vue';
</script>
<template>
  <div class="grid grid-cols-3 ml-32">
    <div>
      <h3 class="pl-8">Por Leer</h3>
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

    <div class="">
      <h3 class="pl-9">Leyendo</h3>
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

    <div class="">
      <h3 class="pl-10">Leido</h3>
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

    <!-- <rawDisplayer class="col-3" :value="list1" title="List 1" />

    <rawDisplayer class="col-3" :value="list2" title="List 2" /> -->
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
      list1: [
        { name: "John", id: 1 },
        { name: "Joao", id: 2 },
        { name: "Jean", id: 3 },
        { name: "Gerard", id: 4 }
      ],
      list2: [
        { name: "Juan", id: 5},
        { name: "Edgard", id: 6 },
        { name: "Johnson", id: 7 }
      ],
      list3: [
        { name: "Paco", id: 5 },
        { name: "Bob", id: 6 },
        { name: "Boby", id: 7 }
      ]
    };
  },
  methods: {
    add: function() {
      this.list.push({ name: "Juan" });
    },
    replace: function() {
      this.list = [{ name: "Edgard" }];
    },
    clone: function(el) {
      return {
        name: el.name + " cloned"
      };
    },
    log: function(evt) {
      if (this.once){
        axios.post('/objectives-update',{
          leer:this.volLeer,
          leyendo:this.volLeyendo,
          leido:this.volLeido,
          id:this.selected
        }).then(response=>{console.log(response)})
        // console.log(this.volLeer);
        // console.log(this.volLeyendo);
        // console.log(this.volLeido);
      }
      this.once=(!this.once);
      //console.log(evt);
      
    }
  },
};
</script>