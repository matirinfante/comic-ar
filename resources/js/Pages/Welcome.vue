<script setup>
import { Head, Link } from '@inertiajs/inertia-vue3';
import BigLogo from '@/Components/BigLogo.vue';
import Footer from '../Components/Footer.vue';
import WelcomeNavBar from '../Components/WelcomeNavBar.vue';

defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    laravelVersion: String,
    phpVersion: String,
});
</script>



<template>

    <Head title="Bienvenido" />

    <div class="relative flex items-top justify-center min-h-screen sm:items-center sm:pt-0 welcomePage">

        <!-- contenido index (sin loguear) -->

        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 mt-32 sm:mt-0">
            <div class="">
                <span class="sr-only">Esta es la página de bienvenida</span>
                <div class="text-xl text-white">
                    <h2>Organiza tu colección de cómics y mangas</h2>
                </div>
                <!-- <div class="flex justify-center pt-8 sm:justify-start sm:pt-0"> -->
                <BigLogo />
                <!-- </div> -->

                <!-- animechan quotes -->
                <div class="flex justify-center py-4 rounded-lg"
                    :class="{ 'bg-white transition ease-in duration-700': !isloading }">
                    <div v-if="isloading" class="">
                        <svg class="inline mr-2 w-8 h-8 text-gray-200 animate-spin dark:text-gray-600 fill-purple-600 svgBorder"
                            viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
                                fill="currentColor" />
                            <path
                                d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
                                fill="currentFill" />
                        </svg>
                        <span class="sr-only">Cargando frase...</span>
                    </div>
                    <div v-else class="text-center w-80 transition ease-in delay-1000">
                        <span class="sr-only">Frase de anime</span>
                        <p
                            class="font-semibold bg-gradient-to-r bg-clip-text text-transparent from-fuchsia-500 via-purple-500 to-blue-500 animate-text">
                            {{ quote }}</p>
                        <p class="font-bold">{{ char }} {{ anime }}</p>
                    </div>
                </div>
            </div>

            <!-- login/register/enter card -->
            <div class="mt-8 bg-[#6875f5] overflow-hidden shadow rounded-lg text-center">
                <div v-if="canLogin" class="px-6 py-4 sm:block">
                    <Link v-if="$page.props.user" :href="route('dashboard')" class="text-sm text-white underline">
                    Ingresar</Link>

                    <template v-else>
                        <div class="flex justify-between mx-10">
                            <Link :href="route('login')" class="text-sm text-white underline">
                            Iniciar Sesión</Link>

                            <Link v-if="canRegister" :href="route('register')" class="text-sm text-white underline">
                            Registrarse</Link>
                        </div>
                    </template>
                </div>
            </div>
        </div>


    </div>

    <!-- seccion 2 -->
    <div class="min-h-screen sm:items-center bg-white w-full">
        <div class="4/5">
            <div class="text-center text-4xl mt-20 px-10 sm:px-6 ">
                <h2>Tener todos tus cómics controlados por fin es fácil</h2>
            </div>
            <div class="text-center text-xl mt-10 text-gray-500 mx-auto px-10 sm:px-0 w-4/5 sm:w-3/5 md:w-1/2">
                <h2>Mantener tu colección organizada y al día ya no te dará pereza, con ComicAR puedes hacerlo de la
                    manera más fácil y en muy poco tiempo.</h2>
            </div>
        </div>

        <div class="flex flex-col sm:flex-row mt-20 text-center">
            <!-- info -->
            <div class="w-full sm:w-1/2 px-10">
                <h2 class="text-slate-400 text-2xl">Crea tu colección en un momento</h2>
                <p class="w-full xl:w-2/5 mx-auto mt-4">¡Basta ya de perder el tiempo catalogando tu colección! Añadir tus cómics a ComicAR es tan sencillo
                    como darle al botón “Añadir a la comicteca”. Un click y listo, por el siguiente cómic.</p>
            </div>
            <!-- img -->
            <div class="w-full sm:w-1/2">
                <img class="mx-auto sm:mx-0" src="/assets/examples/comictecaExample.jpg" alt="comictecaExample" width="80%">
            </div>
        </div>

        <div class="flex flex-col mt-20 pb-20">
            <!-- info -->
            <div class="w-3/5 mx-10 lg:mx-40">
                <h2 class="text-slate-400 text-2xl">¡Qué siga creciendo tu colección!</h2>
                <p class="w-full mt-4">Con ComicAR puedes estar al día de todas las novedades editoriales, pero eso no es todo porque te avisamos cuando se publica cualquier novedad de las colecciones a las que estás suscripto</p>
            </div>
            <!-- img -->
            <div class="mx-10 lg:mx-40 mt-4">
                <img class="mx-auto object-contain" src="/assets/examples/volumesExample.jpg" alt="volumesExample">
            </div>
        </div>
    </div>

    <!-- seccion 3 -->
    <div class="min-h-screen sm:items-center bg-white w-full">
        <div class="line-sep"></div>
        <div class="4/5">
            <div class="text-center text-4xl mt-20 px-10 sm:px-6 ">
                <h2>Lleva tu afición al límite</h2>
            </div>
            
        </div>
        <div class="flex flex-col sm:flex-row mt-20 text-center pb-10">
            <!-- info -->
            <div class="w-full sm:w-1/2 px-10">
                <h2 class="text-slate-400 text-2xl">Tu comicteca</h2>
                <p class="w-full xl:w-2/5 mx-auto mt-4">Navega por tus cómics y colecciones y obtén estadísticas. Así será tu comicteca en ComicAR: tus cómics como nunca antes los has visto, ordenados y listos para admirarlos cuando quieras.</p>
            </div>
            <!-- img -->
            <div class="w-full mt-4 sm:w-1/2 sm:mt-0">
                <img class="mx-auto sm:mx-0" src="/assets/examples/profileExample.jpg" alt="profileExample" width="80%">
            </div>
        </div>
    </div>

    <Footer />
</template>
<style>
div.line-sep {
    height: 3px;
    background: url(/assets/bg_line.jpg) repeat-x 0 0 transparent;
}
</style>

<script>
import axios from 'axios'

export default {
    data() {
        return {
            anime: "",
            char: "",
            quote: "",
            isloading: true
        }
    },
    mounted() {
        this.getQuote();
    },
    methods: {
        getQuote() {
            setTimeout(() =>
                axios.get("/translate").then(response => {
                    this.anime = response.data.anime;
                    this.char = response.data.character + ' -';
                    this.quote = '"' + response.data.quote + '"';
                    this.isloading = false
                }), 400);
        }
    }
}
</script>
<style>
.welcomePage {
    background-blend-mode: soft-light;
    background-color: #0006;
    background-image: url(https://images.pexels.com/photos/6654177/pexels-photo-6654177.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1);
    background-repeat: no-repeat;
    background-size: cover;
}

.svgBorder {

    stroke: #fff;
    stroke-width: 1.5px;
    stroke-dasharray: 0;
    stroke-linejoin: round;
}
</style>
