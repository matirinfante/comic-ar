<script setup>
import { ref } from 'vue';
import { Inertia } from '@inertiajs/inertia';
import { Head, Link } from '@inertiajs/inertia-vue3';
import JetApplicationMark from '@/Components/ApplicationMark.vue';
import JetNavLink from '@/Components/NavLink.vue';


defineProps({
    title: String,
});

const showingNavigationDropdown = ref(false);

const switchToTeam = (team) => {
    Inertia.put(route('current-team.update'), {
        team_id: team.id,
    }, {
        preserveState: false,
    });
};

const logout = () => {
    Inertia.post(route('logout'));
};
</script>

<template>
    <nav class="bg-blue-200 border-b border-gray-100">
        <!-- Primary Navigation Menu -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex">
                    <!-- Logo -->
                    <div class="shrink-0 flex items-center">
                        <Link :href="route('dashboard')">
                        <JetApplicationMark class="block h-9 w-auto" />
                        </Link>
                    </div>

                    <!-- novedades -->
                    <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                        <JetNavLink :href="route('dashboard')">
                            Novedades
                        </JetNavLink>
                    </div>

                    <!-- about -->
                    <div class="hidden space-x-8 sm:-my-px sm:ml-5 sm:flex">
                        <JetNavLink :href="route('dashboard')">
                            Sobre nosotros
                        </JetNavLink>
                    </div>

                </div>
            </div>
        </div>
    </nav>
</template>
