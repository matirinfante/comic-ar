<template>
    <div>
        <div class="flex items-center ml-5">
            <star-rating :inline="true" :star-size="20" :show-rating="false" :rating="total"
            :read-only="true" :increment="0.01"></star-rating> 
        </div>
    </div>
</template>
<script>
import axios from 'axios'
import {$vfm, VueFinalModal, ModalsContainer} from 'vue-final-modal'
import StarRating from 'vue-star-rating'
export default {
    components: {
        VueFinalModal,
        ModalsContainer,
        StarRating,
    },
    data(){
        return{
            total:0
        }
    },
    mounted(){
        this.getScore();
    },
    methods:{
        getScore(){
            axios.get('/edition-score',{params: {
                    edition_id: this.$page.props.edition.id
                }}).then((response) => {
                if (response.data.length > 0) {
                    var count=0;
                    response.data.forEach(element => {
                        count+=element.rating;
                    });
                    this.total=count/response.data.length;
                }
            })
        }
    }
}
</script>