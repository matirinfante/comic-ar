<script setup>
import { useForm } from '@inertiajs/inertia-vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import JetButton from '@/Components/Button.vue';
import JetInput from '@/Components/Input.vue';
import JetInputError from '@/Components/InputError.vue';
import JetLabel from '@/Components/Label.vue';
import { Inertia } from '@inertiajs/inertia'

const props = defineProps({
    volume: Object,
});

const form = useForm({
    title: props.volume?.title,
    ISBN: props.volume?.ISBN,
    argument: props.volume?.argument,
    coverImage: null,

});

const submit = () => {
    Inertia.post(`/volumes/${props.volume.id}`, {
        forceFormData: true,
        _method: "put",
        title: form.title,
        ISBN: form.ISBN,
        argument: form.argument,
        coverImage: form.coverImage,
    });
};
</script>

<template>
    <AppLayout title="Información del Tomo">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                <span class="text-gray-500">Editar Información del Tomo</span>
            </h2>
        </template>

        <div>
            <div class="max-w-md mx-auto py-10 mt-10 sm:px-6 lg:px-8 bg-white shadow md:shadow-lg">
                <!-- CONTENIDO CENTRAL -->

                <form @submit.prevent="submit" class="p-4" enctype="multipart/form-data">
                    <!-- title -->
                    <div>
                        <JetLabel for="title" value="Título" />
                        <JetInput id="title" v-model="form.title" type="text" class="mt-1 block w-full bg-slate-200"
                            required autofocus />
                        <JetInputError class="mt-2" :message="form.errors.title" />
                    </div>

                    <!-- ISBN -->
                    <div class="mt-4">
                        <JetLabel for="ISBN" value="ISBN" />
                        <JetInput id="ISBN" v-model="form.ISBN" type="text" class="mt-1 block w-full bg-slate-200"
                            autocomplete="current-ISBN" />
                        <JetInputError class="mt-2" :message="form.errors.ISBN" />
                    </div>

                    <!-- argument -->
                    <div class="mt-5">
                        <JetLabel for="argument" value="Argumento (Opcional)" />
                        <textarea v-model="form.argument" placeholder="Argument..."
                            class="w-full bg-slate-200"></textarea>
                        <JetInputError class="mt-2" :message="form.errors.argument" />
                    </div>

                    <!-- coverImage -->
                    <div class="mt-4">
                        <JetLabel for="coverImage" value="Imagen de Portada" />
                        <JetInput id="coverImage" @input="form.coverImage = $event.target.files[0]" type="file"
                            class="mt-1 block w-full bg-slate-200 text-gray-500" />
                        <JetInputError class="mt-2" :message="form.errors.coverImage" />
                    </div>


                    <div class="flex items-center justify-end mt-6">
                        <JetButton class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                            Actualizar
                        </JetButton>
                    </div>
                </form>
            </div>
        </div>
    </AppLayout>
</template>
