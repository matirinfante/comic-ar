<script setup>
import {useForm} from '@inertiajs/inertia-vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import JetButton from '@/Components/Button.vue';
import JetInput from '@/Components/Input.vue';
import JetInputError from '@/Components/InputError.vue';
import JetLabel from '@/Components/Label.vue';
import JetCheckbox from '@/Components/Checkbox.vue';
import {Inertia} from '@inertiajs/inertia'
import EditCharacters from "@/Pages/Editions/EditCharacters.vue";
import {toJSON} from "lodash/seq";

const props = defineProps({
    edition: Object,
});
let selected = [];
const form = useForm(
    {
        title: props.edition?.title,
        publisher: props.edition?.publisher,
        language: props.edition?.language,
        format: props.edition?.format,
        isClosed: props.edition.isClosed == 0 ? false : true,
        description: props.edition?.description,
        characters: props.edition?.characters !== null ? JSON.parse(props.edition.characters) : []
    });

function handleSelection(data) {
    form.characters = data
}

const submit = () => {
    // form.post(route('editions.update'));
    Inertia.post(`/editions/${props.edition.id}`, {
        _method: "put",
        title: form.title,
        publisher: form.publisher,
        language: form.language,
        format: form.format,
        isClosed: form.isClosed,
        description: form.description,
        characters: form.characters
    });
};
</script>

<template>
    <AppLayout title="Información de la Edición">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                <!-- <span class="text-gray-500"> -->
                    Editar Información de la Edición
                <!-- </span> -->
            </h2>
        </template>

        <div>
            <div class="max-w-md mx-auto py-10 mt-10 sm:px-6 lg:px-8 bg-white shadow md:shadow-lg">
                <!-- CONTENIDO CENTRAL -->
                <h5 class="text-gray-400 text-center text-xs">Los campos con <span class="text-red-500">*</span> son
                    obligatorios</h5>
                <form @submit.prevent="submit" class="p-4">

                    <!-- isClosed? -->
                    <div class="mb-6">
                        <label class="flex items-center">
                            <JetCheckbox v-model:checked="form.isClosed" name="isClosed" class="shadow-md"/>
                            <span class="ml-2 text-sm text-gray-600">¿Está cerrada?</span>
                        </label>
                    </div>

                    <!-- title -->
                    <div>
                        <JetLabel for="title" value="Título" class="starlabel"/>
                        <JetInput id="title" v-model="form.title" type="text" class="mt-1 block w-full bg-slate-200"
                                  required autofocus/>
                        <JetInputError class="mt-2" :message="form.errors.title"/>
                    </div>

                    <!-- publisher -->
                    <div class="mt-4">
                        <JetLabel for="publisher" value="Editorial" class="starlabel"/>
                        <JetInput id="publisher" v-model="form.publisher" type="text"
                                  class="mt-1 block w-full bg-slate-200" required autocomplete="current-publisher"/>
                        <JetInputError class="mt-2" :message="form.errors.publisher"/>
                    </div>

                    <!-- language -->
                    <div class="mt-4">
                        <JetLabel for="language" value="Idioma" class="starlabel"/>
                        <JetInput id="language" v-model="form.language" type="text"
                                  class="mt-1 block w-full bg-slate-200" required autocomplete="current-language"/>
                        <JetInputError class="mt-2" :message="form.errors.language"/>
                    </div>

                    <!-- format -->
                    <div class="mt-4">
                        <JetLabel for="format" value="Formato" class="starlabel"/>
                        <select id="format" v-model="form.format" required class="h-fit text-xs bg-slate-200">
                            <option value="Rustica/TPB (tapa blanda)">Rustica/TPB (tapa blanda)</option>
                            <option value="Grapa">Grapa</option>
                            <option value="Tapa dura">Tapa dura</option>
                            <option value="Bolsillo">Bolsillo</option>
                        </select>
                    </div>


                    <!-- isStandalone -->
                    <!-- <div class="mt-6">
                        <label class="flex items-center">
                            <JetCheckbox v-model:checked="form.isStandalone" name="isStandalone" class="shadow-md"
                                @change="$emit('input', $event.target.checked)" />
                            <span class="ml-2 text-sm text-gray-600">Is standalone?</span>
                        </label>
                    </div> -->

                    <!-- cantVol -->
                    <!-- <div v-if="!form.isStandalone" class="mt-6">
                        <JetLabel for="cantVol" value="Number of volumes" />
                        <JetInput id="cantVol" v-model="form.cantVol" type="number" class="mt-1 block w-1/2" min="2"
                            max="200" required />
                        <JetInputError class="mt-2" :message="form.errors.cantVol" />
                    </div> -->

                    <!-- description -->
                    <div class="mt-5">
                        <JetLabel for="description" value="Descripcion (Opcional)"/>
                        <textarea v-model="form.description" placeholder="Una descripción"
                                  class="w-full bg-slate-200"></textarea>
                        <JetInputError class="mt-2" :message="form.errors.description"/>
                    </div>
                    <!-- format -->
                    <div class="mt-4">
                        <EditCharacters @selected="handleSelection" v-model="form.characters"
                                        :selected-characters="form.characters"/>
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <JetButton class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                            Actualizar
                        </JetButton>
                    </div>
                </form>
            </div>
        </div>
    </AppLayout>
</template>
