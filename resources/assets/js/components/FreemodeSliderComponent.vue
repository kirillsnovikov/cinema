<template>
    <!-- swiper -->
    <swiper :options="swiperOption">
        <swiper-slide v-for="(film, index) in films" :key="index">
            {{film.title}}
        </swiper-slide>
        <div class="swiper-pagination" slot="pagination"></div>
        <!--<div class="swiper-button-prev" slot="button-prev"></div>-->
        <!--<div class="swiper-button-next" slot="button-next"></div>-->
    </swiper>
</template>

<script>
    export default {
        props: [
            'films'
        ],
        data() {
            return {
                swiperOption: {
                    slidesPerView: 'auto',
                    spaceBetween: 30,
                    freeMode: true,
                    pagination: {
                        el: '.swiper-pagination',
                        clickable: true
                    }
                }
            }
        },
        mounted() {
//            console.log(this.films);
        }
    }
</script>

<style scope>
    .swiper-slide {
        width: 100px;
        height: 100px;
        background-color: #444;
    }

</style>
