<script setup>
import LookingFor from '@/Components/LookingFor.vue';
</script>
<template>
    <div id="stats-container" class="divide-y divide-fuchsia-50">
        <div v-if="messageon" class="py-2">
            <p class="text-center text-lg font-semibold">Objetivos Pendientes</p>
            <div class="mt-2 text-left" v-for="mensaje in message">{{mensaje}}</div>
        </div>
        <div v-else class="py-2">
            <p class="text-center text-lg font-semibold">No posee objetivos pendientes</p>
        </div>
        <div class="flex grid grid-cols-1 sm:grid-cols-2">
            <div class="pt-4 pl-8">
                <p class="text-center font-semibold pb-1 text-lg bg-gradient-to-r bg-clip-text text-transparent from-neutral-900 via-amber-500 to-neutral-900 animate-text">Totales</p>
                <p class="my-4">Agregados a la wishlist: {{totalWish}}</p>
                <p class="my-4">Listas creadas: {{totalList}}</p>
                <p class="my-4">Objetivos pendientes: {{pendent}}</p>
                <p class="my-4">Objetivos completados: {{completed}}</p>
            </div>
            <div class="pt-4">
                <p class="text-center font-semibold pb-2 text-lg bg-gradient-to-r bg-clip-text text-transparent from-neutral-900 via-fuchsia-500 to-neutral-900 animate-text">Tu progreso en ComicAR</p>
                <div v-if="hasInfo">
                    <v-chart class="chart flex justify-center" :option="option" />
                </div>
                <div v-else class="text-center">
                    <p class="font-semibold">No hay datos para mostrar</p>
                    <div class="flex justify-center">
                        <LookingFor class="w-72 h-fit"/>
                    </div>
                    
                </div>
                
            </div>
        </div>
    </div>
</template>
<script>
import axios from 'axios'
import { use } from 'echarts/core';
import {
  DatasetComponent,
  TooltipComponent,
  GridComponent,
  LegendComponent
} from 'echarts/components';
import { BarChart } from 'echarts/charts';
import { CanvasRenderer } from 'echarts/renderers';
import VChart, { THEME_KEY } from 'vue-echarts';
import { ref, defineComponent } from 'vue';

use([
  DatasetComponent,
  TooltipComponent,
  GridComponent,
  LegendComponent,
  BarChart,
  CanvasRenderer
]);
export default {
    components: {
        VChart,
    },
    data(){
        return{
            message:"",
            messageon:false,
            totalWish:0,
            totalList:0,
            completed:0,
            pendent:0,
            option:{},
            barData: [],
            hasInfo:false
        }
    },
    mounted(){
        this.getNotif();
        this.stats();
    },
    methods:{
        getNotif(){
            //var option=3;
            //axios.get('/objnotifications-ask',{params:{option:option}}).then(response=>{
            //if (response.data!=""){
            //    this.message=response.data.split('</br>');
            //    this.messageon=true;
            //    }
            //});
            axios.get('/objMessage').then(response=>{
                if (response.data!=""){
                    this.message=response.data.split('</br>');
                    this.messageon=true;
                }
            });
                
        },
        stats(){
            axios.get('/getStats').then(response=>{
                this.totalWish=response.data.volInWish;
                this.totalList=response.data.booklists;
                this.completed=response.data.completedObj;
                this.pendent=response.data.uncompletedObj;
                this.barData=response.data.allData;
                this.charts();
                if (this.completed==0 && this.totalWish==0 && this.totalList==0){
                    this.hasInfo=false;
                }else{
                    this.hasInfo=true;
                }
            }).catch(function (error) {
                this.hasInfo=false;
            });
        },
        charts(){
            this.option= ref({
            legend: {},
            tooltip: {},
            dataset: {
                source: this.barData
            },
            xAxis: { type: 'category' },
            yAxis: {},
            // Declare several bar series, each will be mapped
            // to a column of dataset.source by default.
            series: [{ type: 'bar' }, { type: 'bar' }, { type: 'bar' }]
        });
        }
    }
}
</script>
<style scoped>
@media (min-width: 320px){
    .chart {
        height: 40vh;
    }
}
@media (min-width: 425px){
    .chart {
        height: 60vh;
    }
}
@media (min-width: 1024px){
    .chart {
        height: 40vh;
    }
}
@media (min-width: 1366px){
    .chart {
        height: 50vh;
    }
}
@media (min-width: 1920px){
    .chart {
        height: 30vh;
    }
}
/* .chart {
  height: 60vh;
} */
</style>