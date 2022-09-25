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
                    <div class="flex justify-end">
                        <JetNavLink :href="route('editions.edit', edition.id)"
                            class="text-gray-500 mr-10 mt-2 mb-2 md:mb-0 hover:text-gray-800">
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
                            <p class="px-4 text-md text-yellow-300 font-semibold sm:ml-4 md:ml-10 pt-6">
                                {{edition.publisher}}
                            </p>
                            <h2 class="px-4 text-3xl font-bold text-white sm:ml-4 md:ml-10 mt-2">
                                {{edition.title}}
                            </h2>
                            <p v-if="volumes.length > 0"
                                class="px-4 text-md text-green-400 font-semibold sm:ml-4 md:ml-10 pt-6">
                            <div class="flex">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                    class="bi bi-files mr-2" viewBox="0 0 16 16">
                                    <path
                                        d="M13 0H6a2 2 0 0 0-2 2 2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h7a2 2 0 0 0 2-2 2 2 0 0 0 2-2V2a2 2 0 0 0-2-2zm0 13V4a2 2 0 0 0-2-2H5a1 1 0 0 1 1-1h7a1 1 0 0 1 1 1v10a1 1 0 0 1-1 1zM3 4a1 1 0 0 1 1-1h7a1 1 0 0 1 1 1v10a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V4z" />
                                </svg>
                                {{volumes.length}} tomos
                            </div>
                            </p>
                            <p class="px-4 text-md text-slate-400 font-light sm:ml-4 md:ml-10 pt-1">
                                {{edition.format}}
                            </p>
                            <div class="flex justify-start">
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
    
                            </div>
                            <div class="flex justify-end">
                            <div class="bg-green-500 mt-4 py-1 pr-5 rounded-l-full">
                                <p class="text-white-200 pl-4 md:pl-14">
                                    <Link href="/apibooks" :data="{id:edition.id}">&#10133;Agregar Tomo</Link>
                                </p>
                            </div>
                            </div>
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
                                    <Link :href="route('volumes.show', volume.id)">
                                    <img class="w-full h-50" :src="volume.coverImage" :alt="volume.title" />
                                    <div class="text-center py-4 bg-gray-300 text-gray-500">
                                        <h4 class="mb-3 text-md font-semibold tracking-tight">{{volume.title}}-{{volume.id}}
                                        </h4>
                                    </div>
                                    </Link>
                                </div>
                            </div>
    
    
                        </div>
                        <div class="text-gray-800 border-y-2 bg-white py-10 flex flex-row justify-between">
                            <!-- Valoración/Idioma/Propietarios? -->
                            <div class="ml-8 md:ml-20 lg:ml-28">
                                Valoración
                            </div>
                            <div class="">
                                {{edition.language}}
                            </div>
                            <div class="mr-8 md:mr-20 lg:mr-28">
                                Propietarios?
                            </div>
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
                            <p v-if="edition.description != null" class="text-mm text-gray-700 px-10 pt-6 w-full md:w-1/2">
                                {{edition.description}}
                            </p>
                            <p v-else class="text-mm text-gray-700 px-10 pt-6 w-full md:w-1/2">
                                La edición no cuenta con una descripción
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
                
<script>
export default{
    data(){
        return{

        }
    },
    methods:{
        addV(){
            //console.log(this.edition.id);
            this.$inertia.get('/apibooks/' + this.edition.id);
            
        }
    }
}
</script>
