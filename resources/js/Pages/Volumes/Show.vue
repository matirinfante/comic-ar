<script setup>
    import { Head, Link } from '@inertiajs/inertia-vue3';
    import AppLayout from '@/Layouts/AppLayout.vue';
    import JetNavLink from '@/Components/NavLink.vue';
    
    
    defineProps({
        volume: Object,
        edition: Object
    })
    
    function formatDate(date) {
        var year = date.getUTCFullYear();
        var month = date.getUTCMonth() + 1;
        var dt = date.getUTCDate();
        var hour = date.getUTCHours();
        var min = date.getUTCMinutes();
    
        if (dt < 10) {
            dt = '0' + dt;
        }
        if (month < 10) {
            month = '0' + month;
        }
        return (dt + '/' + month + '/' + year + ' - ' + hour + ':' + min);
    }
    </script>
                        
    <template>
        <AppLayout :title="volume[0].title">
            <template #header>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    <span class="text-gray-500">Tomo de {{volume[0].title}}</span>
                </h2>
            </template>
    
            <div>
                <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
                    <!-- CONTENIDO CENTRAL -->
                    <div class="flex justify-end">
                        <JetNavLink :href="route('volumes.edit', volume[0].id)"
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
                    <div class="mx-6 z-40 border-2 rounded-lg relative">
                        <div class="w-full pb-8 sm:px-0 bg-slate-700 rounded-t-lg h-48">
                            <div
                                class="h-44 md:h-52 lg:h-72 flex justify-start absolute left-2 md:left-10 top-2 md:top-10 border-2">
                                <img class="" :src="volume[0].coverImage" :alt="volume[0].title" />
                            </div>
                            <div
                                class="w-1/2 h-36 flex justify-start absolute left-28 md:left-44 lg:left-60 top-2 md:top-10">
                                <p class="text-white md:text-2xl font-bold ml-6">#{{volume[0].number}}</p>
                            </div>
                        </div>
                        <div class="flex">
                            <div class="text-center w-3/12 hidden md:block">
                                <!-- empty div -->
                            </div>
                            <div class="h-fit text-center flex text-2xl">
                                <Link :href="route('editions.show', edition[0].id)"
                                    class="text-gray-500 hover:text-gray-800 inline p-3">
                                {{edition[0].title}}
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                    stroke="currentColor" class="w-6 h-6 inline">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                                </svg>
                                </Link>
                            </div>
                        </div>
                        <div class="border-y-2 bg-white pt-0 pb-10 md:pt-5 flex flex-col md:flex-row justify-between">
                            <div class="md:w-6/12">
                                <h2 class="text-lg font-bold text-gray-600 ml-10 mt-6 md:mt-8 lg:mt-20">
                                    Argumento
                                </h2>
                                <p v-if="volume[0].argument != null" class="text-mm text-gray-700 px-10">
                                    {{volume[0].argument}}
                                </p>
                                <p v-else class="text-mm text-gray-700 px-10">
                                    El tomo/volúmen no cuenta con un argumento actualmente
                                </p>
                            </div>
    
                            <div class="md:w-6/12 md:pl-36">
                                <h2 class="text-lg font-bold text-gray-600 ml-10 mt-10 md:mt-8 lg:mt-20">
                                    ISBN
                                </h2>
                                <p v-if="volume[0].ISBN != null" class="text-mm text-gray-700 px-10 w-50">
                                    {{volume[0].ISBN}}
                                </p>
                                <p v-else class="text-mm text-gray-700 px-10">
                                    El tomo/volúmen no cuenta con un ISBN actualmente
                                </p>
                            </div>
                        </div>
    
                        <!-- última actualización (sin formato de fecha) -->
                        <div class="bg-slate-200 flex flex-col md:flex-row justify-between">
                            <div class="md:w-6/12 py-2">
                                <h2 class="text-lg font-bold text-gray-600 ml-10">
                                    Última modificación
                                </h2>
                                <p v-if="volume[0].updated_at != null" class="text-mm text-gray-700 px-10">
                                    {{ formatDate(new Date(volume[0].updated_at)) }}
                                </p>
                                <p v-else class="text-mm text-gray-700 px-10">
                                    No disponible
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </AppLayout>
    </template>
                        