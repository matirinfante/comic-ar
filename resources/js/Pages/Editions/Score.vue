<template>
    <div>
        <div class="flex items-center ml-5">
            <star-rating :inline="true" :star-size="20" :rating="total"
                         :read-only="true" :increment="0.01" :rounded-corners="true" :border-width="2"
                         :star-points="[23,2, 14,17, 0,19, 10,34, 7,50, 23,43, 38,50, 36,34, 46,19, 31,17]"
                         text-class="custom-text"></star-rating><p class="custom-text">/ 5</p>
        </div>
    </div>
</template>
<script>
import axios from 'axios'
import {$vfm, VueFinalModal, ModalsContainer} from 'vue-final-modal'
import StarRating from 'vue-star-rating'

export default {
    components: {
        StarRating,
    },
    data() {
        return {
            total: 0
        }
    },
    mounted() {
        this.getScore();
    },
    methods: {
        getScore() {
            axios.get('/edition-score', {
                params: {
                    edition_id: this.$page.props.edition.id
                }
            }).then((response) => {
                if (response.data.length > 0) {
                    var count = 0;
                    response.data.forEach(element => {
                        count += element.rating;
                    });
                    this.total = count / response.data.length;
                }
            })
        }
    }
}
</script>
<style>
.custom-text {
    font-weight: bold;
    font-size: 1.5em;
    padding-left: 10px;
    padding-right: 5px;
    color: #000000;
    background: #fff;
}
</style>
