<script setup>
import { Head, Link } from '@inertiajs/inertia-vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import JetNavLink from '@/Components/NavLink.vue';

defineProps({
    edition: JSON,
    volumes: Object
})

</script>
                
<template>
    <AppLayout :title="edition.title">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                <span class="text-gray-500">Edición de {{edition.title}}</span>
            </h2>
        </template>

        <div>
            <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
                <!-- CONTENIDO CENTRAL -->
                <div class="mx-6 z-40 border-2 rounded-lg">
                    <div class="w-full pb-8 px-4 sm:px-0 bg-slate-700 rounded-t-lg">
                        <p class="text-md text-yellow-300 font-semibold sm:ml-4 md:ml-10 pt-6">
                            {{edition.publisher}}
                        </p>
                        <h2 class="text-3xl font-bold text-white sm:ml-4 md:ml-10 mt-2">
                            {{edition.title}}
                        </h2>
                        <p v-if="volumes.length > 0" class="text-md text-green-400 font-semibold sm:ml-4 md:ml-10 pt-6">
                        <div class="flex">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="bi bi-files mr-2" viewBox="0 0 16 16">
                                <path
                                    d="M13 0H6a2 2 0 0 0-2 2 2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h7a2 2 0 0 0 2-2 2 2 0 0 0 2-2V2a2 2 0 0 0-2-2zm0 13V4a2 2 0 0 0-2-2H5a1 1 0 0 1 1-1h7a1 1 0 0 1 1 1v10a1 1 0 0 1-1 1zM3 4a1 1 0 0 1 1-1h7a1 1 0 0 1 1 1v10a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V4z" />
                            </svg>
                            {{volumes.length}} tomos
                        </div>
                        </p>
                        <p class="text-md text-slate-400 font-light sm:ml-4 md:ml-10 pt-1">
                            {{edition.format}}
                        </p>
                    </div>
                    <div class="h-12 bg-white shadow-lg flex border-y">
                        <div class="align-middle ml-10 my-auto">
                            <JetNavLink :href="route('editions.show', edition.id)"
                                :active="route().current('editions.show', edition.id)">
                                Información
                            </JetNavLink>
                        </div>

                    </div>
                    <div v-if="volumes.length > 0" class="bg-white">
                        <!-- Tomos/Volumenes -->

                        <div class="grid sm:grid-cols-3 md:grid-cols-6 lg:grid-cols-6 pt-5">
                            <div v-for="volume in volumes" :key="volume.id" class="w-24 mx-auto mb-4 rounded-lg">
                                <!-- <Link :href="route('editions.show', volume)"> -->
                                <!-- <img class="w-full h-50" :src="edition.title+'.jpg'" @error="$event.target.src='/edition_cover.jpg'" :alt="edition.title" /> -->
                                <img class="" :src="'/img/edition_cover.jpg'" :alt="volume.title" />
                                <div class="text-center py-4 bg-gray-300 text-gray-500">
                                    <h4 class="mb-3 text-md font-semibold tracking-tight">{{volume.title}}-{{volume.id}}
                                    </h4>
                                </div>
                                <!-- </Link> -->
                            </div>
                        </div>


                    </div>
                    <div class="border-y-2 bg-white py-10 flex flex-row justify-between">
                        <!-- Valoración/Idioma/Propietarios? -->
                        <div class="text-gray-800 px-5 md:px-40">
                            Valoración
                        </div>
                        <div class="text-gray-800 px-5 md:px-40">
                            {{edition.language}}
                        </div>
                        <div class="text-gray-800 px-5 md:px-40">
                            Propietarios?
                        </div>
                        <!-- <p class="text-center text-gray-800"></p>
                            <p class="text-center text-gray-500 mt-2">{{edition.language}}</p> -->
                    </div>
                    <div class="bg-white py-10">
                        <!-- Información/Descripción -->
                        <h2 class="text-2xl font-bold text-gray-600 ml-10 mt-2">
                            Sobre esta edición
                        </h2>
                        <p class="text-mm text-gray-700 ml-10 pt-6">
                            {{edition.format}}
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
                        <p v-if="edition.description != null" class="text-mm text-gray-700 ml-10 pt-6">
                            {{edition.description}}
                        </p>
                        <p v-else class="text-mm text-gray-700 ml-10 pt-6">
                            La edición no cuenta con una descripción
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
                