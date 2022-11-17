<template>
    <transition enter-active-class="ease-out duration-300" enter-class="opacity-0" enter-to-class="opacity-100"
        leave-active-class="ease-in duration-200" leave-class="opacity-100" leave-to-class="opacity-0">
        <div class="relative z-10" aria-labelledby="modal-title" role="dialog" aria-modal="true" v-show="modal">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>

            <div class="fixed inset-0 z-10 overflow-y-auto">
                <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">

                    <transition enter-active-class="ease-out duration-300"
                        enter-class="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                        enter-to-class="opacity-100 translate-y-0 sm:scale-100"
                        leave-active-class="ease-in duration-200" leave-class="opacity-100 translate-y-0 sm:scale-100"
                        leave-to-class="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                        <div class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-fit sm:max-w-lg pr-5"
                            v-show="modal">
                            <div class="pt-3 sm:flex sm:flex-row-reverse">
                                <button v-on:click="close" type="button"
                                    class="mt-3 inline-flex w-full rounded-md bg-white text-base font-medium text-gray-700 shadow-sm sm:mt-0 sm:ml-3 sm:w-auto ">&#10060;</button>
                            </div>
                            <div class="bg-white pb-4 sm:pb-4">
                                <div class="sm:flex sm:items-start">
                                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                        <h3 class="text-lg font-semibold leading-6 text-gray-900" id="modal-title">
                                            Comprobar Datos</h3>
                                        <div class="mt-2">
                                            <h5 class="my-4 text-gray-400 text-center text-xs">Los campos con <span
                                                    class="text-red-500">*</span> son
                                                obligatorios</h5>
                                            <form v-on:submit.prevent="submitForm">
                                                <div>
                                                    <label for="title" class="starlabel">Título</label>
                                                    <input v-model="title" id="title" type="text"
                                                        class="w-full border border-gray-300 px-3 py-2 rounded-lg shadow-sm focus:ring-1 focus:ring-indigo-500"
                                                        required>
                                                </div>
                                                <div>
                                                    <label for="volumeNum" class="starlabel">Tomo Nº</label>
                                                    <input v-model="volumeNum" id="volumeNum" type="text"
                                                        class="w-full border border-gray-300 px-3 py-2 rounded-lg shadow-sm focus:ring-1 focus:ring-indigo-500"
                                                        required>
                                                </div>
                                                <div class="mt-2">
                                                    <label for="isbn">ISBN:</label>
                                                    <input v-model="isbn" id="isbn" type="text"
                                                        class="w-full border border-gray-300 px-3 py-2 rounded-lg shadow-sm focus:ring-1 focus:ring-indigo-500">
                                                </div>
                                                <div>
                                                    <input type="hidden" id="edition_id" v-model="idEdition" required>
                                                </div>
                                                <div class="mt-2">
                                                    <label for="argument">Reseña:</label>
                                                    <textarea v-model="review" id="argument"
                                                        class="resize-none pb-20 w-full border border-gray-300 px-3 py-2 rounded-lg shadow-sm focus:ring-1 focus:ring-indigo-500"></textarea>
                                                </div>
                                                <div v-if='ruta'>
                                                    <label for="coverImage">Ruta imagen:</label>
                                                    <input v-model="img" id="coverImage" type="text"
                                                        class="w-full border border-gray-300 px-3 py-2 rounded-lg shadow-sm focus:ring-1 focus:ring-indigo-500">
                                                </div>
                                                <div v-else>
                                                    <label for="cover">Subir imagen:</label>
                                                    <input id="cover" type="file" v-on:change="fileSelected"
                                                        class="w-full border border-gray-300 px-3 py-2 rounded-lg shadow-sm focus:ring-1 focus:ring-indigo-500">
                                                </div>
                                                <div>
                                                    <button v-on:click="upload" type="button"
                                                        class="mt-5 rounded-md border border-transparent bg-blue-600 px-4 py-2  font-light text-white shadow-sm hover:bg-violet-700 sm:w-auto sm:text-xs">{{ imgButton }}</button>
                                                </div>

                                                <button type="submit"
                                                    class="mt-5 rounded-md border border-transparent bg-green-600 px-4 py-2 text-base font-medium text-white shadow-sm hover:bg-violet-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2  sm:w-auto sm:text-sm">Agregar</button>

                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </transition>
                </div>
            </div>
        </div>
    </transition>
</template>

<script>
import axios from 'axios'
export default {
    props: {
        modal: Boolean,
        ftitle: String,
        fisbn: String,
        fimg: String,
        freview: String,
        editionid: String
    },
    data() {
        return {
            ruta: true,
            imgButton: "Subir imagen del ordenador",
            file: null,
            volumeNum: ""
        }
    },
    computed:{
        title:{
                get() { return this.ftitle },
                set(value) {this.$emit('changeTitle',value)}
            },
        isbn:{
            get(){return this.fisbn},
            set(value){this.$emit('changeIsbn',value)}
        },
        idEdition(){return this.editionid},
        review:{
            get(){return this.freview},
            set(value){this.$emit('changeReview',value)}
        },
        img:{
            get(){return this.fimg},
            set(value){this.$emit('changeImg',value)}
        }
    },
    methods: {
        close() {
            this.$emit('close', false);
            this.ruta = true;
            this.imgButton = "Subir imagen del ordenador"
        },
        submitForm() {
            if (this.freview.length > 999) {
                alert('La reseña es muy larga');
            } else {
                axios.post('/volumes', {
                    title: this.title,
                    ISBN: this.isbn,
                    argument: this.review,
                    coverImage: this.img,
                    edition_id: this.idEdition,
                    coverFile: this.file,
                    number: this.volumeNum
                }, {
                    headers: {
                        "Content-Type": "multipart/form-data",
                    },
                }).then(function (response) {
                    window.location = response.data.redirect + '/' + edition_id.value;
                }).catch(function (error) { console.log(error); alert('Error en la carga. Revise los datos del formulario.') });
            }

        },
        upload() {
            this.ruta = !this.ruta;
            if (this.ruta) {
                this.file = null;
                this.imgButton = "Subir imagen del ordenador"
            } else {
                this.imgButton = "Ingresar url de la imagen";
            }

        },
        fileSelected(event) {
            var value="";
            this.file = event.target.files[0];
            this.$emit('changeImg',value);  //Si hay url no toma la imagen del archivo
        }
    }
}
</script>