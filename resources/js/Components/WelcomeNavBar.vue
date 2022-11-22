<script setup>
import { Head, Link } from '@inertiajs/inertia-vue3';
import BigLogo from '@/Components/BigLogo.vue';
import Footer from '../Components/Footer.vue';
import WelcomeNavBar from '../Components/WelcomeNavBar.vue';
import { ref } from 'vue';
import { Inertia } from '@inertiajs/inertia';
import JetApplicationMark from '@/Components/ApplicationMark.vue';

defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    laravelVersion: String,
    phpVersion: String,
});


</script>

<template>
    <nav class="bg-blue-200 border-b border-gray-100">
        <!-- Primary Navigation Menu -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="">
                    <!-- Logo -->
                    <div class="my-4">
                        <Link :href="route('dashboard')">
                        <JetApplicationMark class="block h-9 w-auto" />
                        </Link>
                    </div>
                </div>
                <div v-if="canLogin" class=" mt-4 px-6 py-4 sm:block dark:bg-blue-200">
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
    </nav>
</template>
