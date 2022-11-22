<script setup>
import { Head, Link } from '@inertiajs/inertia-vue3';
import BigLogo from '@/Components/BigLogo.vue';
import Footer from '../Components/Footer.vue';

defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    laravelVersion: String,
    phpVersion: String,
});
</script>



<template>

    <Head title="Quiénes somos" />

    <div class="flex items-top justify-center min-h-screen bg-[#f3f4f6]">

        <!-- contenido -->

        <!-- enlaces según login -->
        <div v-if="canLogin" class="absolute px-6 py-4 sm:block">
            <Link v-if="$page.props.user" :href="route('dashboard')" class="text-sm text-gray-900 underline">
            Ingresar al sitio</Link>

            <template v-else>
                <div class="flex justify-between mx-10">
                    <Link :href="route('login')" class="text-sm text-gray-900 underline">
                    Iniciar Sesión</Link>

                    <Link v-if="canRegister" :href="route('register')" class="text-sm ml-6 text-gray-900 underline">
                    Registrarse</Link>
                </div>
            </template>
        </div>

        <!-- información -->
        <div class="mt-16">
            <BigLogo />
            <div class="text-5xl mt-10 text-center">
                <h2>Nos mueve la pasión</h2>
            </div>
            <div class="text-2xl text-gray-500 mt-4 text-center">
                <h2>¿Qué es ComicAR?</h2>
            </div>
            <div class="text-xl mt-4 w-3/4 md:w-1/2 mx-auto">
                <p>ComicAR es un equipo de personas apasionadas por los cómics y la tecnología, que decidieron crear una
                    aplicación que ayuda a los lectores de cómics a organizar sus colecciones. Queremos revolucionar el
                    mundo del cómic e incentivar su lectura.</p>
            </div>
            <div class="text-5xl text-gray-500 mt-16 text-center">
                <h2>Integrantes</h2>
            </div>
            <div class="flex flex-wrap justify-center mt-10 mb-16">
                <div class="w-6/12 sm:w-4/12 md:w-2/12 px-4">
                    <img src="/assets/about/mri.jpg"
                        alt="Matías Ricardo Infante" class="shadow rounded-full max-w-full h-auto align-middle border-none" />
                        <p class="text-center text-gray-500 text-md mt-2">Matías Ricardo Infante</p>
                </div>
                <div class="w-6/12 sm:w-4/12 md:w-2/12 px-4">
                    <img src="/assets/about/pdr.jpg"
                        alt="Pablo Damian Romero" class="shadow rounded-full max-w-full h-auto align-middle border-none" />
                        <p class="text-center text-gray-500 text-md mt-2">Pablo Damian Romero</p>
                </div>
                <div class="w-6/12 sm:w-4/12 md:w-2/12 px-4">
                    <img src="/assets/about/mpm.jpg"
                        alt="Matías Federico Peralta Macri" class="shadow rounded-full max-w-full h-auto align-middle border-none" />
                        <p class="text-center text-gray-500 text-md mt-2">Matías Peralta Macri</p>
                </div>
            </div>
        </div>

    </div>

    <Footer />
</template>