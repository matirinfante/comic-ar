<script setup>

import { Link } from '@inertiajs/inertia-vue3';

</script>
<template>
    <footer
        class="mt-auto p-4 bg-neutral-900 shadow md:flex md:items-center md:justify-between md:p-6 dark:bg-neutral-900">
        <span class="text-sm text-gray-500 sm:text-center dark:text-gray-400">©{{ new Date().getFullYear() }} |
            <span class="font-bold">COMICAR</span>
            .&nbsp;&nbsp;
            Todos los derechos reservados.
        </span>
        <ul class="flex flex-wrap items-center mt-3 text-sm text-gray-500 dark:text-gray-400 sm:mt-0">
            <li>
                <Link :href="route('aboutUs')" class="mr-4 hover:underline md:mr-6">
                    Quiénes somos
                </Link>
            </li>
            <li>
                <Link :href="route('PrivacyPolicy')" class="mr-4 hover:underline md:mr-6">
                    Politica de privacidad
                </Link>
            </li>
        </ul>
    </footer>
</template>
