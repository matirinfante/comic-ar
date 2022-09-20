<script setup>
import { useForm } from '@inertiajs/inertia-vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import JetButton from '@/Components/Button.vue';
import JetInput from '@/Components/Input.vue';
import JetInputError from '@/Components/InputError.vue';
import JetLabel from '@/Components/Label.vue';
import JetCheckbox from '@/Components/Checkbox.vue';

const form = useForm({
    title: '',
    publisher: '',
    language: '',
    format: 'Rustica/TPB (tapa blanda)',
    isStandalone: false,
    cantVol: '2',
    description: '',
});

const submit = () => {
    form.post(route('editions.store'));
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

                    <!-- title -->
                    <div>
                        <JetLabel for="title" value="Title" />
                        <JetInput id="title" v-model="form.title" type="text" class="mt-1 block w-full" required
                            autofocus />
                        <JetInputError class="mt-2" :message="form.errors.title" />
                    </div>

                    <!-- publisher -->
                    <div class="mt-4">
                        <JetLabel for="publisher" value="Publisher" />
                        <JetInput id="publisher" v-model="form.publisher" type="text" class="mt-1 block w-full" required
                            autocomplete="current-publisher" />
                        <JetInputError class="mt-2" :message="form.errors.publisher" />
                    </div>

                    <!-- language -->
                    <div class="mt-4">
                        <JetLabel for="language" value="Language" />
                        <JetInput id="language" v-model="form.language" type="text" class="mt-1 block w-full" required
                            autocomplete="current-language" />
                        <JetInputError class="mt-2" :message="form.errors.language" />
                    </div>

                    <!-- format -->
                    <div class="mt-4">
                        <JetLabel for="format" value="Format" />
                        <select id="format" v-model="form.format" required class="h-fit text-xs">
                            <option value="Rustica/TPB (tapa blanda)">Rustica/TPB (tapa blanda)</option>
                            <option value="Grapa">Grapa</option>
                            <option value="Tapa dura">Tapa dura</option>
                            <option value="Bolsillo">Bolsillo</option>
                        </select>
                    </div>

                    <!-- isStandalone -->
                    <div class="mt-6">
                        <label class="flex items-center">
                            <JetCheckbox v-model:checked="form.isStandalone" name="isStandalone" class="shadow-md" @change="$emit('input', $event.target.checked)"/>
                            <span class="ml-2 text-sm text-gray-600">Is standalone?</span>
                        </label>
                    </div>
                    
                    <!-- cantVol -->
                    <div v-if="!form.isStandalone" class="mt-6">
                        <JetLabel for="cantVol" value="Number of volumes" />
                        <JetInput id="cantVol" v-model="form.cantVol" type="number" class="mt-1 block w-1/2" min="2" max="200" required />
                        <JetInputError class="mt-2" :message="form.errors.cantVol" />
                    </div>
                    
                    <!-- description -->
                    <div class="mt-4">
                        <JetLabel for="description" value="Description (Optional)" />
                        <textarea v-model="form.description" placeholder="Edition's description" class="w-full"></textarea>
                        <JetInputError class="mt-2" :message="form.errors.description" />
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
        