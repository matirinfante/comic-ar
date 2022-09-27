<template>
    <div>
        <!-- First modal -->
        <vue-final-modal v-model="showModal" classes="modal-container" content-class="modal-content"
                         @click-outside="clickOutside">
            <button class="modal__close" @click="showModal = false">
            </button>
            <span class="modal__title">Publicando reseña</span>
            <div class="modal__content">
                <star-rating v-model:rating="rating" :rounded-corners="true" :border-width="6"
                             :show-rating="false" class="p-6"></star-rating>
                <div class="flex justify-center">
                    <div class="mb-3 mt-5 xl:w-96">
                        <label for="exampleFormControlTextarea1" class="form-label inline-block mb-2 text-gray-700">Comentario
                            (opcional)</label>
                        <textarea
                            class="form-control block w-full px-3 py-1.5 text-base font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
                            id="exampleFormControlTextarea1"
                            rows="3"
                            placeholder="Tu comentario" v-model="comment"></textarea>
                    </div>
                </div>
            </div>
            <div class="modal__action">
                <button :disabled="modified" @click="confirm"
                        class="inline-block px-6 py-2 border-2 border-purple-600 text-purple-600 font-medium text-xs leading-tight uppercase rounded-full hover:bg-black hover:bg-opacity-5 focus:outline-none focus:ring-0 transition duration-150 ease-in-out"
                        :class="{'hidden':modified}">
                    Publicar
                </button>
                <button @click="showModal = false"
                        class="inline-block px-6 py-2 border-2 border-purple-600 text-purple-600 font-medium text-xs leading-tight uppercase rounded-full hover:bg-black hover:bg-opacity-5 focus:outline-none focus:ring-0 transition duration-150 ease-in-out">
                    Cancelar
                </button>
            </div>
        </vue-final-modal>
        <div class="flex justify-center my-5">
            <button @click="showModal = true" :class="{'hidden':alreadyReviewed}"
                    class="inline-block px-6 py-2 border-2 border-purple-600 text-purple-600 font-medium text-xs leading-tight uppercase rounded-full hover:bg-purple-600 hover:text-white focus:outline-none focus:ring-0 transition duration-150 ease-in-out">
                Añadir reseña
            </button>
        </div>
    </div>
    <div v-if="alreadyReviewed">
        <article class="mt-9 pr-9 ml-10 bg-yellow-200 mr-10 p-6 mb-9 rounded-md ">
            <div class="flex items-center mb-4 space-x-4">
                <div class="space-y-1 font-bold dark:text-white">
                    <p>{{ $page.props.user.name }}
                    </p>
                </div>
            </div>
            <div class="flex items-center mb-1">
                <star-rating inactive-color="#e1bad9" active-color="#cc1166" :inline="true" :star-size="15" :show-rating="false" :rating="this.review.rating"
                             :read-only="true" :increment="0.01" :rounded-corners="true" :border-width="2"
                             :star-points="[23,2, 14,17, 0,19, 10,34, 7,50, 23,43, 38,50, 36,34, 46,19, 31,17]"></star-rating>
                <h3 class="ml-2 text-sm font-semibold text-gray-900 dark:text-white"></h3>
            </div>
            <footer class="mb-5 text-sm text-gray-500 dark:text-gray-400">
                <p>Reseñó la edición el
                    <time datetime="2017-03-03 19:00">{{ this.review.created_at }}</time>
                </p>
            </footer>
            <p v-if="this.review.description !== ''" class="mb-2 font-light text-gray-500 dark:text-gray-400">
                {{ this.review.description }}</p>
        </article>
    </div>
    <div v-if="editionReviews !== []" class="text-gray-800 border-y-2 bg-white py-10">
        <!-- Reviews compiladas -->
        <h2 class="text-2xl font-bold text-gray-600 ml-10 mt-2">¿Qué dicen los usuarios?</h2>
        <div v-for="review in editionReviews">
            <article class="mt-9 pr-9 ml-10 ">
                <div class="flex items-center mb-4 space-x-4">
                    <div class="space-y-1 font-bold dark:text-white">
                        <p>{{ review.id }}
                        </p>
                    </div>
                </div>
                <div class="flex items-center mb-1">
                    <star-rating :inline="true" :star-size="15" :show-rating="false" :rating="review.rating"
                                 :read-only="true" :increment="0.01" :rounded-corners="true" :border-width="2"
                                 :star-points="[23,2, 14,17, 0,19, 10,34, 7,50, 23,43, 38,50, 36,34, 46,19, 31,17]"></star-rating>
                    <h3 class="ml-2 text-sm font-semibold text-gray-900 dark:text-white"></h3>
                </div>
                <footer class="mb-5 text-sm text-gray-500 dark:text-gray-400">
                    <p>Reseñó la edición el
                        <time datetime="2017-03-03 19:00">{{ review.created_at }}</time>
                    </p>
                </footer>
                <p v-if="review.description !== ''" class="mb-2 font-light text-gray-500 dark:text-gray-400">
                    {{ review.description }}</p>
            </article>
        </div>
    </div>
</template>
<script>
import {$vfm, VueFinalModal, ModalsContainer} from 'vue-final-modal'
import StarRating from 'vue-star-rating'


export default {
    components: {
        VueFinalModal,
        ModalsContainer,
        StarRating,
    },
    props: {
        showState: {type: Boolean, default: false}
    },
    data: () => ({
        showModal: false,
        showConfirmModal: false,
        rating: 0,
        comment: "",
        alreadyReviewed: false,
        review: null,
        editionReviews: []
    }),
    mounted() {
        this.checkReview();
    },
    methods: {
        confirm(e) {
            e.preventDefault()
            axios.post('/reviews', {
                rating: this.rating,
                description: this.comment,
                edition_id: this.$page.props.edition.id,
                user_id: this.$page.props.user.id
            }).then((response) => {
                this.showModal = false
                this.alreadyReviewed = true
                this.review = response.data.review
                this.$swal(
                    'Publicado!',
                    'Tu reseña ha sido publicada :)',
                    'success'
                )
            })
        },
        clickOutside() {
            this.rating = 0
        },
        checkReview() {
            axios.get('/check-review', {
                params: {
                    user_id: this.$page.props.user.id,
                    edition_id: this.$page.props.edition.id
                }
            }).then((response) => {
                if (response.data.length > 0) {
                    this.alreadyReviewed = true;
                    this.review = response.data[0];
                }
            })
            axios.get('/edition-reviews', {
                params: {
                    edition_id: this.$page.props.edition.id
                }
            }).then((response) => {
                if (response.data.length > 0) {
                    this.editionReviews = response.data
                }
            })
        }
    },
    computed: {
        modified: function () {
            return !(this.rating !== 0)
        },
        alreadyReviewed: function () {
            return this.alreadyReviewed
        },
    }
}
</script>

<style scoped>
::v-deep .modal-container {
    display: flex;
    justify-content: center;
    align-items: center;
}

::v-deep .modal-content {
    position: relative;
    display: flex;
    flex-direction: column;
    max-height: 90%;
    margin: 0 1rem;
    padding: 1rem;
    border: 1px solid #e2e8f0;
    border-radius: 0.25rem;
    background: #fff;
}

.modal__title {
    margin: 0 2rem 0.5rem 0;
    font-size: 1.5rem;
    font-weight: 700;
}

.modal__content {
    flex-grow: 1;
    overflow-y: auto;
}

.modal__action {
    display: flex;
    justify-content: center;
    align-items: center;
    flex-shrink: 0;
    padding: 1rem 0 0;
}

.modal__close {
    position: absolute;
    top: 0.5rem;
    right: 0.5rem;
}

</style>

<style scoped>
.dark-mode div::v-deep .modal-content {
    border-color: #2d3748;
    background-color: #1a202c;
}
</style>
