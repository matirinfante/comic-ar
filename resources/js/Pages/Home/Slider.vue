<template>
    <carousel :settings="settings" :breakpoints="breakpoints">
        <slide v-for="(elem,index) in data" :key="index">
            <div class="mb-4 carousel__item" @click="elemPressed(elem.id)">
                <img :src="elem.coverImage"
                     class="object-cover max-w-full rounded-lg" alt="">
            </div>
        </slide>

        <template #addons>
            <navigation/>
            <pagination/>
        </template>
    </carousel>
</template>

<script>
// If you are using PurgeCSS, make sure to whitelist the carousel CSS classes
import 'vue3-carousel/dist/carousel.css';
import {Carousel, Slide, Pagination, Navigation} from 'vue3-carousel';

export default {
    name: 'Slider',
    props: {
        data: {type: Array, required: false, default: () => [{id: 0, title: "Hola"}]}
    },
    components: {
        Carousel,
        Slide,
        Pagination,
        Navigation,
    },
    data: () => ({
        // carousel settings
        settings: {
            itemsToShow: 2,
            snapAlign: 'center',
        },
        // breakpoints are mobile first
        // any settings not specified will fallback to the carousel settings
        breakpoints: {
            // 700px and up
            700: {
                itemsToShow: 3.5,
                snapAlign: 'center',
            },
            // 1024 and up
            1024: {
                itemsToShow: 5,
                snapAlign: 'start',
            },
        },
    }),
    methods: {
        elemPressed(value) {
            this.$inertia.get('/volumes/' + value);
        }
    }

};
</script>
<style>
.carousel__item {
    min-height: 200px;
    width: 100%;
    background-color: var(--vc-clr-primary);
    color: var(--vc-clr-white);
    font-size: 20px;
    border-radius: 8px;
    display: flex;
    justify-content: center;
    align-items: center;
}

.carousel__slide {
    padding: 10px;
}

.carousel__prev,
.carousel__next {
    box-sizing: content-box;
    border: 5px solid white;
}
</style>
