<script setup>
import { useForm } from '@inertiajs/inertia-vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import JetButton from '@/Components/Button.vue';
import JetInput from '@/Components/Input.vue';
import JetInputError from '@/Components/InputError.vue';
import JetLabel from '@/Components/Label.vue';

const form = useForm({
    title: '',
    publisher: '',
});

const submit = () => {
    form.post(route('login'));
};
</script>
        
<template>
    <AppLayout title="Crear Nueva Edición">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                <span class="text-gray-500">Crear Nueva Edición</span>
            </h2>
        </template>

        <div>
            <div class="max-w-md mx-auto py-10 mt-10 sm:px-6 lg:px-8 bg-white shadow md:shadow-lg">
                <!-- CONTENIDO CENTRAL -->
                <form @submit.prevent="submit" class="p-4">
                    <div>
                        <JetLabel for="title" value="Title" />
                        <JetInput id="title" v-model="form.title" type="text" class="mt-1 block w-full" required
                            autofocus />
                        <JetInputError class="mt-2" :message="form.errors.title" />
                    </div>

                    <div class="mt-4">
                        <JetLabel for="publisher" value="Publisher" />
                        <JetInput id="publisher" v-model="form.publisher" type="text" class="mt-1 block w-full" required
                            autocomplete="current-publisher" />
                        <JetInputError class="mt-2" :message="form.errors.publisher" />
                    </div>
                    
                    <div class="mt-4">
                        <JetLabel for="languaje" value="Languaje" />
                        <JetInput id="languaje" v-model="form.languaje" type="text" class="mt-1 block w-full" required
                            autocomplete="current-languaje" />
                        <JetInputError class="mt-2" :message="form.errors.languaje" />
                    </div>


                    <div class="flex items-center justify-end mt-4">
                        <JetButton class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                            Crear
                        </JetButton>
                    </div>
                </form>
            </div>
        </div>
    </AppLayout>
</template>
        