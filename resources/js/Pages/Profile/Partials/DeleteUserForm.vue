<script setup>
import {ref} from 'vue';
import {useForm} from '@inertiajs/inertia-vue3';
import JetActionSection from '@/Components/ActionSection.vue';
import JetDialogModal from '@/Components/DialogModal.vue';
import JetDangerButton from '@/Components/DangerButton.vue';
import JetInput from '@/Components/Input.vue';
import JetInputError from '@/Components/InputError.vue';
import JetSecondaryButton from '@/Components/SecondaryButton.vue';

const confirmingUserDeletion = ref(false);
const passwordInput = ref(null);

const form = useForm({
    password: '',
});

const confirmUserDeletion = () => {
    confirmingUserDeletion.value = true;

    setTimeout(() => passwordInput.value.focus(), 250);
};

const deleteUser = () => {
    form.delete(route('current-user.destroy'), {
        preserveScroll: true,
        onSuccess: () => closeModal(),
        onError: () => passwordInput.value.focus(),
        onFinish: () => form.reset(),
    });
};

const closeModal = () => {
    confirmingUserDeletion.value = false;

    form.reset();
};
</script>

<template>
    <JetActionSection>
        <template #title>
            Borrar cuenta
        </template>

        <template #description>
            Eliminar su cuenta de forma permanente.
        </template>

        <template #content>
            <div class="max-w-xl text-sm text-gray-600">
                Una vez su cuenta sea borrada, todos sus recursos y datos se eliminarán de forma permanente. Antes de
                borrar su cuenta, por favor descargue cualquier dato o información que desee conservar.
            </div>

            <div class="mt-5">
                <JetDangerButton @click="confirmUserDeletion">
                    Borrar cuenta
                </JetDangerButton>
            </div>

            <!-- Delete Account Confirmation Modal -->
            <JetDialogModal :show="confirmingUserDeletion" @close="closeModal">
                <template #title>
                    Borrar cuenta
                </template>

                <template #content>
                    ¿Está seguro que desea eliminar su cuenta? Una vez que se elimine su cuenta, todos sus recursos y
                    datos se eliminarán de forma permanente. Ingrese su contraseña para confirmar que desea eliminar su
                    cuenta de forma permanente.

                    <div class="mt-4">
                        <JetInput
                            ref="passwordInput"
                            v-model="form.password"
                            type="password"
                            class="mt-1 block w-3/4"
                            placeholder="Password"
                            @keyup.enter="deleteUser"
                        />

                        <JetInputError :message="form.errors.password" class="mt-2"/>
                    </div>
                </template>

                <template #footer>
                    <JetSecondaryButton @click="closeModal">
                        Cancelar
                    </JetSecondaryButton>

                    <JetDangerButton
                        class="ml-3"
                        :class="{ 'opacity-25': form.processing }"
                        :disabled="form.processing"
                        @click="deleteUser"
                    >
                        Borrar cuenta
                    </JetDangerButton>
                </template>
            </JetDialogModal>
        </template>
    </JetActionSection>
</template>
