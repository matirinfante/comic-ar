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

    <WelcomeNavBar />


    <div class="relative flex items-top justify-center min-h-screen bg-white dark:bg-gray-100 sm:items-center sm:pt-0">
        <!-- <div v-if="canLogin" class="hidden fixed top-0 right-0 px-6 py-4 sm:block dark:bg-blue-200">
            <Link v-if="$page.props.user" :href="route('dashboard')"
                class="text-sm text-gray-700 dark:text-gray-900 underline">Ir a inicio</Link>

            <template v-else>
                <Link :href="route('login')" class="text-sm text-gray-700 dark:text-gray-500 underline">Log In</Link>

                <Link v-if="canRegister" :href="route('register')"
                    class="ml-6 text-sm text-gray-700 dark:text-gray-500 underline">Register</Link>
            </template>
        </div> -->




        <!-- contenido index (sin loguear) -->

        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="flex justify-center pt-8 sm:justify-start sm:pt-0">
                <BigLogo />
            </div>

            <div class="mt-8 bg-white dark:bg-gray-900 overflow-hidden shadow sm:rounded-lg">
                <div class="p-6 text-white text-center">
                    &#128055;&#128055;&#128055;
                    <br>
                    Diseño en proceso...

                    <div v-if="canLogin" class="hidden mt-4 px-6 py-4 sm:block dark:bg-blue-200">
                        <Link v-if="$page.props.user" :href="route('dashboard')"
                            class="text-sm text-gray-700 dark:text-gray-900 underline">Ir a inicio</Link>

                        <template v-else>
                            <Link :href="route('login')" class="text-sm text-gray-700 dark:text-gray-500 underline">Iniciar Sesión</Link>

                            <Link v-if="canRegister" :href="route('register')"
                                class="ml-6 text-sm text-gray-700 dark:text-gray-500 underline">Registrarse</Link>
                        </template>
                    </div>
                </div>

            </div>

            <div class="flex justify-center mt-4">

                <div class="ml-4 text-center text-sm text-gray-500 sm:text-right sm:ml-0">
                    Laravel v{{ laravelVersion }} (PHP v{{ phpVersion }})
                </div>
            </div>

        </div>
    </div>
    <Footer />
</template>
