<script setup>
import { Head, Link } from '@inertiajs/inertia-vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import JetNavLink from '@/Components/NavLink.vue';
import Review from "@/Pages/Editions/Review.vue";
import Score from "@/Pages/Editions/Score.vue";
import Characters from "@/Pages/Editions/Characters.vue";
import Pagination from '../../Components/Pagination.vue';

defineProps({
    edition: JSON,
    volumes: Object,
    subscriptions: Object

})

</script>

<template>
    <AppLayout :title="edition.title">
        <template #header>
            <span class="sr-only">Esta es la vista de la Edicion {{edition.title}}</span>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Edición de <span class="text-gray-500">{{ edition.title }}</span>
            </h2>
        </template>
        <div>
            <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
                <!-- CONTENIDO CENTRAL -->
                <div class="flex justify-end">
                    <JetNavLink :href="route('editions.edit', edition.id)"
                        class="text-gray-500 mr-10 mt-2 mb-2 md:mb-0 hover:text-gray-800 text-base">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                            <path
                                d="M5.433 13.917l1.262-3.155A4 4 0 017.58 9.42l6.92-6.918a2.121 2.121 0 013 3l-6.92 6.918c-.383.383-.84.685-1.343.886l-3.154 1.262a.5.5 0 01-.65-.65z" />
                            <path
                                d="M3.5 5.75c0-.69.56-1.25 1.25-1.25H10A.75.75 0 0010 3H4.75A2.75 2.75 0 002 5.75v9.5A2.75 2.75 0 004.75 18h9.5A2.75 2.75 0 0017 15.25V10a.75.75 0 00-1.5 0v5.25c0 .69-.56 1.25-1.25 1.25h-9.5c-.69 0-1.25-.56-1.25-1.25v-9.5z" />
                        </svg>
                        Editar Información
                    </JetNavLink>
                </div>
                <div class="mx-6 z-40 border-2 rounded-lg">
                    <div class="w-full pb-8 sm:px-0 bg-slate-700 rounded-t-lg">
                        <div class="flex justify-between">
                            <p class="px-4 text-md text-yellow-300 font-semibold sm:ml-4 md:ml-10 pt-6">
                                {{ edition.publisher }}
                            </p>
                            <button v-if="edition.usrSubscribe == 'n'" v-on:click="subscribe(edition.id)"
                                class="px-4 text-md text-gray-300 font-semibold sm:ml-4 md:ml-10 pt-6 hover:text-white hover:underline">
                                <span class="font-thin">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="w-6 h-6 inline">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" />
                                    </svg>Quiero novedades!</span>
                            </button>
                            <button v-if="edition.usrSubscribe == 'y'" v-on:click="unsubscribe(edition.id)"
                                class="px-4 text-md text-gray-300 font-semibold sm:ml-4 md:ml-10 pt-6 hover:text-white hover:underline">
                                <span class="font-thin">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="w-6 h-6 inline">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M9.143 17.082a24.248 24.248 0 003.844.148m-3.844-.148a23.856 23.856 0 01-5.455-1.31 8.964 8.964 0 002.3-5.542m3.155 6.852a3 3 0 005.667 1.97m1.965-2.277L21 21m-4.225-4.225a23.81 23.81 0 003.536-1.003A8.967 8.967 0 0118 9.75V9A6 6 0 006.53 6.53m10.245 10.245L6.53 6.53M3 3l3.53 3.53" />
                                    </svg>
                                    Anular novedades</span>
                            </button>
                        </div>
                        <h2 class="px-4 text-3xl font-bold text-white sm:ml-4 md:ml-10 mt-2">
                            {{ edition.title }}
                        </h2>
                        <p v-if="edition.totalVol > 0"
                            class="px-4 text-md text-green-400 font-semibold sm:ml-4 md:ml-10 pt-6">
                        <div class="flex">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="bi bi-files mr-2" viewBox="0 0 16 16">
                                <path
                                    d="M13 0H6a2 2 0 0 0-2 2 2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h7a2 2 0 0 0 2-2 2 2 0 0 0 2-2V2a2 2 0 0 0-2-2zm0 13V4a2 2 0 0 0-2-2H5a1 1 0 0 1 1-1h7a1 1 0 0 1 1 1v10a1 1 0 0 1-1 1zM3 4a1 1 0 0 1 1-1h7a1 1 0 0 1 1 1v10a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V4z" />
                            </svg>
                            <div v-if="edition.totalVol > 1">
                                {{ edition.totalVol }} tomos
                            </div>
                            <div v-else>
                                {{ edition.totalVol }} tomo
                            </div>
                        </div>
                        <p v-if="edition.isStandalone == 1" class="text-orange-300">
                            Tomo único
                        </p>
                        <p v-else class="text-orange-300">
                            Serie de tomos
                        </p>
                        </p>
                        <p class="px-4 text-md text-slate-400 font-light sm:ml-4 md:ml-10 pt-1">
                            {{ edition.format }}
                        </p>
                        <div v-show="hasAll" class="flex justify-end">
                            <div class="bg-yellow-700 hover:bg-yellow-600 mt-4 py-1 pr-5 rounded-l-full">
                                <button v-on:click="complete(edition.id)" class="text-gray-200 pl-2 md:pl-6">
                                    <span class="font-thin">
                                        Tengo la edición completa </span>
                                </button>
                            </div>
                        </div>

                        <div class="flex justify-between">
                            <div class="bg-zinc-500 mt-4 py-1 pr-5 rounded-r-full">
                                <p class="text-gray-200 pl-4 md:pl-14">
                                    <span class="font-thin" v-if="edition.isClosed == 0">
                                        En curso
                                    </span>
                                    <span class="font-thin" v-else>
                                        Terminada
                                    </span>
                                </p>
                            </div>

                            <!-- agregar tomos si no esta terminada-->
                            <div v-if="edition.isClosed == 0">
                                <!-- si no es standalone -->
                                <div v-if="edition.isStandalone == false" class="">
                                    <div
                                        class="bg-green-700 text-white hover:text-gray-100 hover:bg-green-600 mt-4 py-1 pr-5 rounded-l-full">
                                        <p class="pl-4 md:pl-8">
                                            <Link href="/apibooks" :data="{ id: edition.id }">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" class="w-6 h-6 inline">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M12 9v6m3-3H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            Agregar Tomo
                                            </Link>
                                        </p>
                                    </div>
                                </div>
                                <!-- agregar tomos si es standalone (max 1) -->
                                <div v-if="edition.isStandalone == true && volumes.data.length < 1" class="">
                                    <div
                                        class="bg-green-700 text-white hover:text-gray-100 hover:bg-green-600 mt-4 py-1 pr-5 rounded-l-full">
                                        <p class="pl-4 md:pl-8">
                                            <Link href="/apibooks" :data="{ id: edition.id }">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" class="w-6 h-6 inline">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M12 9v6m3-3H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            Agregar Tomo
                                            </Link>
                                        </p>
                                    </div>
                                </div>

                            </div>
                        </div>


                    </div>
                    <div class="h-12 bg-white shadow-lg flex border-y">
                        <div class="align-middle ml-10 my-auto">
                            <JetNavLink preserve-scroll :href="route('editions.show', edition.id)"
                                :active="route().current('editions.show', edition.id)"
                                class="text-base border-purple-400">
                                Información
                            </JetNavLink>
                        </div>
                        <div class="align-middle ml-10 my-auto">
                            <JetNavLink preserve-scroll :href="route('artworks.show', edition.id)" class="text-base">
                                Artworks
                            </JetNavLink>
                        </div>
                    </div>
                    <div v-if="edition.totalVol > 0" class="bg-white">
                        <!-- Tomos/Volumenes -->

                        <div class="grid sm:grid-cols-3 md:grid-cols-6 lg:grid-cols-6 pt-5">
                            <div v-for="volume in dataVolumes.data" :key="volume.id"
                                class="w-26 p-3 mx-auto mb-4 rounded-lg">
                                <Link :href="route('volumes.show', volume.id)">
                                <div class="relative">
                                    <img class="w-full h-52" :src="volume.coverImage" :alt="volume.title" />
                                    <div
                                        class="absolute inset-0 z-10 text-white text-center flex flex-col items-center justify-center opacity-0 bg-gray-900 hover:opacity-100 bg-opacity-50 duration-300">
                                        {{ volume.title }} #{{ volume.number }}
                                    </div>
                                </div>
                                </Link>
                                <div v-if="volume.inComicteca == 0" class="text-center group">
                                    <button v-on:click="comicteca(volume.id, true); volume.inComicteca = 1"
                                        class="inline-block w-full py-2 border-2 border-purple-600 text-purple-600 hover:bg-purple-600 hover:text-white transition duration-150 ease-in-out">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor"
                                            class="w-6 h-6 mx-auto inline group-hover:w-5 group-hover:h-5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m6-6H6" />
                                        </svg>
                                        <span
                                            class="text-xs hidden group-hover:inline transition delay-250 ease-in-out">Agregar
                                            a comicteca</span>
                                    </button>
                                </div>
                                <div v-if="volume.inComicteca == 1" class="text-center group">
                                    <button v-on:click="comicteca(volume.id, false); volume.inComicteca = 0"
                                        class="inline-block w-full py-2 border-2 border-green-600 text-white hover:bg-green-600 hover:text-white transition duration-150 ease-in-out">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"
                                            class="w-6 h-6 mx-auto inline group-hover:hidden" stroke="green">
                                            <path fill="green"
                                                d="M470.6 105.4c12.5 12.5 12.5 32.8 0 45.3l-256 256c-12.5 12.5-32.8 12.5-45.3 0l-128-128c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0L192 338.7 425.4 105.4c12.5-12.5 32.8-12.5 45.3 0z" />
                                        </svg>
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor"
                                            class="w-6 h-6 mx-auto hidden group-hover:inline group-hover:w-5 group-hover:h-5">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                        </svg>
                                        <span
                                            class="text-xs hidden group-hover:inline transition delay-250 ease-in-out">Quitar
                                            de
                                            comicteca</span>
                                    </button>
                                </div>


                            </div>
                        </div>
                        <div class="p-2">
                            <Pagination :links="dataVolumes.links" />
                        </div>

                    </div>
                    <Characters />
                    <div class="text-gray-800 border-y-2 bg-white py-10 flex flex-row justify-between">
                        <!-- Valoración/Idioma/Propietarios? -->
                        <div class="grid place-items-center ml-8 md:ml-20 lg:ml-28">
                            <p class="font-extrabold">Valoración</p>
                            <Score />
                        </div>
                        <div class="">
                            <p class="font-extrabold">Lenguaje</p>
                            <p>{{ edition.language }}</p>
                        </div>
                        <div class="mr-8 md:mr-20 lg:mr-28">
                            <p class="font-extrabold">Lo tienen</p>
                        </div>
                    </div>
                    <div class="bg-white py-10">
                        <!-- Información/Descripción -->
                        <h2 class="text-2xl font-bold text-gray-600 ml-10 mt-2">
                            Sobre esta edición
                        </h2>
                        <p class="text-mm text-gray-700 ml-10 pt-6">
                            {{ edition.format }}
                        <div v-if="edition.format == 'Rustica/TPB (tapa blanda)'"
                            class="mt-2 pr-9 text-gray-500 w-full md:w-1/2">
                            A pesar de que la encuadernación rústica se conoce comúnmente como «tapa blanda», lo cierto
                            es que la cubierta no tiene que ser necesariamente flexible, aunque suele ser así
                        </div>
                        <div v-if="edition.format == 'Grapa'" class="mt-2 pr-9 text-gray-500 w-full md:w-1/2">
                            La encuadernación grapada es una de las formas de empastar un documento que más se usa en el
                            sector. Se trata de un tipo de encuadernación sencillo y que resulta especialmente útil
                            cuando se tienen volúmenes modestos, de pocas páginas
                        </div>
                        <div v-if="edition.format == 'Tapa dura'" class="mt-2 pr-9 text-gray-500 w-full md:w-1/2">
                            La encuadernación cartoné, conocida popularmente como «encuadernación de tapa dura», es un
                            tipo de encuadernación en la que el libro, cosido o encolado, está forrado simplemente con
                            una cubierta rígida de cartón, pegada al lomo. Esta cubierta recubre el libro en todas sus
                            superficies exteriores
                        </div>
                        <div v-if="edition.format == 'Bolsillo'" class="mt-2 pr-9 text-gray-500 w-full md:w-1/2">
                            Se denomina libro de bolsillo al tipo de edición de libros que se comercializa con un
                            formato especialmente manejable y con un precio más asequible que el de otras modalidades.​
                            La edición de bolsillo admite cualquier tipo de género o materia en el contenido de los
                            libros
                        </div>
                        </p>

                        <!-- Standalone? -->
                        <p v-if="edition.isStandalone == 1" class="text-mm text-gray-700 ml-10 pt-10">
                            Tomo único
                        </p>
                        <p v-else class="text-mm text-gray-700 ml-10 pt-10">
                            Serie de tomos
                        </p>

                        <h2 class="text-2xl font-bold text-gray-600 ml-10 mt-20">
                            Descripción
                        </h2>
                        <p v-if="edition.description != null" class="text-mm text-gray-700 px-10 pt-6 w-full md:w-1/2">
                            {{ edition.description }}
                        </p>
                        <p v-else class="text-mm text-gray-700 px-10 pt-6 w-full md:w-1/2">
                            La edición no cuenta con una descripción
                        </p>
                    </div>
                    <div class="text-gray-800 border-y-2 bg-white py-10">
                        <!-- Reviews -->
                        <div class="flex justify-center">
                            <h2 class="text-2xl font-bold text-gray-600 mt-2">Opina sobre
                                {{ edition.title }}</h2>

                        </div>
                        <Review :show-state="showModal"></Review>
                    </div>

                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script>
import toastr from 'toastr-comicar';
import 'toastr-comicar/build/toastr.min.css'; 
export default {
    data() {
        return {
            dataVolumes: this.volumes,
            hasAll: false
        }
    },
    mounted() {
        this.checkAll()
    },
    methods: {
        addV() {
            //console.log(this.edition.id);
            this.$inertia.get('/apibooks/' + this.edition.id);

        },
        comicteca(id, state) {
            axios.post('/comictecas', { volume_id: id, status: state }).then(response => {
                this.checkAll()
            })
            if(state){
                axios.post('/comictecaStatus').then(response=>{
                    if (!response.data){
                        toastr.options.positionClass="toast-bottom-right";
                        toastr.options.progressBar = true;
                        toastr.error('Insignia desbloqueada');    
                }});
                
            }
        },
        complete(id) {
            axios.post('/comictecas-complete', { edition_id: id }).then(response => {
                this.dataVolumes.data = response.data;
                this.checkAll()
            });
            axios.post('/comictecaStatus').then(response=>{
                console.log(response.data);
                if (!response.data){
                    console.log(response.data);
                    toastr.options.positionClass="toast-bottom-right";
                    toastr.options.progressBar = true;
                    toastr.error('Insignia desbloqueada');    
            }});
        },
        subscribe(id) {
            axios.post('/edition-subscription', { edition_id: id }).then(response => {
                // console.log(response.data);
                this.$inertia.get('/editions/' + this.edition.id);
            })

        },
        unsubscribe(id) {
            axios.post('/edition-unsubscription', { edition_id: id }).then(response => {
                // console.log(response.data)
                this.$inertia.get('/editions/' + this.edition.id);
            })

        },
        checkAll() {
            this.hasAll = false;
            this.dataVolumes.data.forEach(volume => {
                if (volume['inComicteca'] == 0) {
                    this.hasAll = true;
                }
            });
        }
    }
}
</script>
