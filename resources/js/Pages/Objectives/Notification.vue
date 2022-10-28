<template>
    <transition enter-active-class="ease-out duration-300" enter-class="opacity-0" enter-to-class="opacity-100" leave-active-class="ease-in duration-200" leave-class="opacity-100" leave-to-class="opacity-0">
        <div class="relative z-10" aria-labelledby="modal-title" role="dialog" aria-modal="true" v-show="messageon">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>

        <div class="fixed inset-0 z-10 overflow-y-auto">
            <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">

            <transition enter-active-class="ease-out duration-300" enter-class="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" enter-to-class="opacity-100 translate-y-0 sm:scale-100" leave-active-class="ease-in duration-200" leave-class="opacity-100 translate-y-0 sm:scale-100" leave-to-class="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                <div class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-fit sm:max-w-lg pr-5">
                    <div class="pt-3 sm:flex sm:flex-row-reverse">
                        <button v-on:click="closenotif" type="button" class="mt-3 inline-flex w-full rounded-md bg-white text-base font-medium text-gray-700 shadow-sm sm:mt-0 sm:ml-3 sm:w-auto ">&#10060;</button>
                    </div>
                    <div class="bg-white pb-4 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4">
                                <h3 class="text-lg font-semibold leading-6 text-gray-900 text-center" id="modal-title">Estado diario</h3>
                                <div class="mt-2 text-left" v-for="mensaje in message">
                                    {{mensaje}}
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
export default {
    props:['message','messageon'],
    data(){
        return{
        }
    },
    mounted(){        
    },
    methods:{
        closenotif(){
            this.$emit('closenotif',false);
        }
    }
}
</script>