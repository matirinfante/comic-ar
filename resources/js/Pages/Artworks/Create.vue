<script setup>
import { useForm } from '@inertiajs/inertia-vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import JetButton from '@/Components/Button.vue';
import JetInput from '@/Components/Input.vue';
import JetInputError from '@/Components/InputError.vue';
import JetLabel from '@/Components/Label.vue';

const form = useForm({
    title: '',
    description: '',
    editionId: window.location.href.split("id=").slice(-1)[0],
    imgUrl: null,
});

const submit = () => {
    form.post(route('artworks.store'));
};
</script>

<template>
    <AppLayout title="Subir artwork">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                <!-- <span class="text-gray-500"> -->
                    Subir artwork
                <!-- </span> -->
            </h2>
        </template>

        <div>
            <div class="max-w-md mx-auto py-10 mt-10 sm:px-6 lg:px-8 bg-white shadow md:shadow-lg">
                <!-- CONTENIDO CENTRAL -->
                <form @submit.prevent="submit" class="p-4">

                    <!-- title -->
                    <div>
                        <JetLabel for="title" value="Título" />
                        <JetInput id="title" v-model="form.title" type="text" class="mt-1 block w-full bg-slate-200"
                            autofocus />
                        <JetInputError class="mt-2" :message="form.errors.title" />
                    </div>

                    <!-- description -->
                    <div class="mt-4">
                        <JetLabel for="description" value="Descripción"/>
                        <textarea v-model="form.description" placeholder="Una descripción..." class="w-full"></textarea>
                        <JetInputError class="mt-2" :message="form.errors.description"/>
                    </div>

                    <!-- imgUrl -->
                    <div class="mt-4">
                        <JetLabel for="imgUrl" value="Imagen" />
                        <JetInput id="imgUrl" @input="form.imgUrl = $event.target.files[0]" type="file"
                            class="mt-1 block w-full bg-slate-200 text-gray-500" />
                        <JetInputError class="mt-2" :message="form.errors.imgUrl" />
                    </div>


                    <div class="flex items-center justify-end mt-6">
                        <JetButton class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                            Subir
                        </JetButton>
                    </div>
                </form>
            </div>
        </div>
    </AppLayout>
</template>
<script>
export default {
    data(){
        return{
            editionId:null
        }
    },
    mounted(){
        const url = window.location.href;
        const lastParam = url.split("id=").slice(-1)[0];
        this.editionId = lastParam;
        // console.log(lastParam);
    }
}
</script>
