<template>
    <div v-if="links.length > 3">

        <div class="flex flex-wrap justify-center sm:justify-end">
            <template v-for="( link, key ) in links" :key="key">
                <div v-if="link.url === null" v-html="link.label" class="
            mb-1
            mr-1
            px-3
            py-2
            text-gray-400
            text-sm
            leading-4
            border
            rounded
            "></div>
                <Link preserve-scroll v-else :href="link.url" v-html="link.label" class="
            mb-1
            mr-1
            px-3
            py-2
            text-gray-900
            text-sm
            leading-4
            border
            rounded
            hover:bg-white
            focus:text-purple-500
            focus:border-purple-500
            " :class="{ 'border-purple-300': link.active }">
                </Link>
            </template>
        </div>
    </div>
</template>
<script setup>
import { Link } from '@inertiajs/inertia-vue3';
defineProps({
    links: [],
});
</script>