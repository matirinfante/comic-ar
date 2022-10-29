<script setup>
import { Head, Link } from '@inertiajs/inertia-vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
</script>
<template>
    <AppLayout title="Comicteca">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                <!-- <span class="text-gray-500"> -->
                    Mi Comicteca
                <!-- </span> -->
            </h2>
        </template>
        <div class="pt-3 bg-violet-50">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <p class="font-bold text-xl mb-3 ml-3 mt-2 text-white w-fit bg-violet-700 px-2 rounded-xl">Cantidad de
                    Volúmenes: {{ cantVol }}</p>

                <div v-for="edition in allVol" class="divide-y divide-y-1 divide-blue-200">
                    <p class="font-semibold text-lg mt-2 text-center">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="#6D28D9" class="w-6 h-6 inline">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                        </svg>
                        <span class="text-gray-600">&nbsp;{{ edition.title }}&nbsp;</span>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="#6D28D9" class="w-6 h-6 inline">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                        </svg>

                    </p>
                    <div>
                        <k-progress active status="success" type="line" :border="true"
                            :color="['#210FFF', '#8A30B7', '#CA21A4']" :bg-color="'#D9CFFC'" :percent=edition.progress>
                        </k-progress>

                        <div class="grid sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4 justify-items-center pt-2">

                            <div v-for="volume in edition['volumes']" :key="volume.id" class="mb-3">
                                <div class="relative">
                                    <Link :href="route('volumes.show', volume.id)">
                                    <img class="h-60" :src="volume.coverImage">
                                    <div
                                        class="font-semibold absolute inset-0 z-10 text-white text-center flex flex-col items-center justify-center opacity-0 bg-gray-900 hover:opacity-100 bg-opacity-50 duration-300">
                                        {{ volume.title }} #{{ volume.number }}
                                    </div>
                                    </Link>
                                </div>
                                <div class="text-center group">
                                    <button v-on:click="remove(volume.id)"
                                        class=" inline-block w-full py-2 border-2 border-red-400 text-red-400 hover:bg-red-400 hover:text-white transition duration-150 ease-in-out">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="w-6 h-6 mx-auto inline">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                        </svg>
                                        <span class="text-xs hidden group-hover:inline transition delay-250 ease-in-out">Quitar</span>
                                    </button>
                                </div>


                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>


    </AppLayout>
</template>
<script>
import KProgress from 'k-progress-v3';
export default {
    props: ['comicteca', 'edCol'],
    components: {
        AppLayout,
        KProgress
    },
    data() {
        return {
            allVol: this.edCol,
            cantVol: 0
        }
    },
    mounted() {
        this.countVol();
    },
    methods: {
        remove(id) {
            axios.post('/comictecas.update', { volume_id: id, status: false }).then(response => {
                this.allVol = response.data;
                this.countVol()
            })
        },
        countVol() {
            this.cantVol = 0;
            this.allVol.forEach(element => {
                this.cantVol += element['volumes'].length;
            });
        }
    }
}
</script>
