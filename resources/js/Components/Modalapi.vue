<template>
    <transition enter-active-class="ease-out duration-300" enter-class="opacity-0" enter-to-class="opacity-100" leave-active-class="ease-in duration-200" leave-class="opacity-100" leave-to-class="opacity-0">
        <div class="relative z-10" aria-labelledby="modal-title" role="dialog" aria-modal="true" v-show="modal">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>

        <div class="fixed inset-0 z-10 overflow-y-auto">
            <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">

            <transition enter-active-class="ease-out duration-300" enter-class="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" enter-to-class="opacity-100 translate-y-0 sm:scale-100" leave-active-class="ease-in duration-200" leave-class="opacity-100 translate-y-0 sm:scale-100" leave-to-class="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                <div class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg" v-show="modal">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                        <h3 class="text-lg font-medium leading-6 text-gray-900" id="modal-title">Comprobar Datos</h3>
                        <div class="mt-2">
                            <form>
                                <div>
                                    <label for="ftitle">Titulo:</label>
                                    <input v-model="ftitle" id="title" type="text" class="w-full border border-gray-300 px-3 py-2 rounded-lg shadow-sm focus:ring-1 focus:ring-indigo-500">
                                </div>
                                <div>
                                    <label for="fisbn">ISBN:</label>
                                    <input v-model="fisbn" id="isbn" type="text" class="w-full border border-gray-300 px-3 py-2 rounded-lg shadow-sm focus:ring-1 focus:ring-indigo-500">
                                </div>
                                <div>
                                    <input type="text" id="edition_id" v-model="editionid">
                                </div>
                                <div>
                                    <label for="freview">Reseña:</label>
                                    <textarea v-model="freview" id="argument" class="w-full border border-gray-300 px-3 py-2 rounded-lg shadow-sm focus:ring-1 focus:ring-indigo-500"></textarea>
                                </div>
                                <div>
                                    <label for="fimg">Ruta imagen:</label>
                                    <input v-model="fimg" id="coverImage" type="text" class="w-full border border-gray-300 px-3 py-2 rounded-lg shadow-sm focus:ring-1 focus:ring-indigo-500">
                                </div>
                                
                                <button v-on:click="submit" type="button" class="inline-flex w-full justify-center rounded-md border border-transparent bg-green-600 px-4 py-2 text-base font-medium text-white shadow-sm hover:bg-violet-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 sm:ml-3 sm:w-auto sm:text-sm">Agregar</button>

                            </form>
                        </div>
                        </div>
                    </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                        
                        <button v-on:click="close" type="button" class="mt-3 inline-flex w-full justify-center rounded-md border border-gray-300 bg-white px-4 py-2 text-base font-medium text-gray-700 shadow-sm hover:bg-red-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">Cancelar</button>
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
    props:{
        modal: Boolean,
        ftitle: String,
        fisbn: String,
        fimg: String,
        freview: String,
        editionid:String
    },
    methods:{
        close(){
            this.$emit('close',false)
        },
        submit(){
            axios.post('/volumes', {
                title:this.ftitle,
                isbn:this.fisbn,
                argument:this.freview,
                coverImage:this.fimg,
                edition_id:this.editionid
            }).then(function (response) {console.log(response);}).catch(function (error) {console.log(error);});
        }
    }
}
</script>