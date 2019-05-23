<template>
    <!-- swiper -->
    <swiper :options="swiperOption">
        <swiper-slide v-for="(film, index) in films" :key="index">
            <div class="card" style="width: 18rem;">
                <img :src="'https://loremflickr.com/300/400/art/?random=' + film.image" class="card-img-top" :alt="'Постер к фильму ' + film.title" :title="'Постер к фильму ' + film.title">
                    <div class="card-body">
                    <h5 class="card-title">{{film.title}}</h5>
                    <p class="card-text">{{film.description_short.substring(0, 40) + '...'}}</p>
                    <a :href="route + '/' + film.slug" class="btn btn-primary">К просмотру</a>
                </div>
            </div>
        </swiper-slide>
        <div class="swiper-pagination" slot="pagination"></div>
        <!--<div class="swiper-button-prev" slot="button-prev"></div>-->
        <!--<div class="swiper-button-next" slot="button-next"></div>-->
    </swiper>
</template>

<script>
    export default {
        props: [
            'films',
            'route'
        ],
        data() {
            return {
                swiperOption: {
                    slidesPerView: 'auto',
                    spaceBetween: 30,
                    freeMode: true,
                    pagination: {
                        el: '.swiper-pagination',
//                        type: 'progressbar',
                        dynamicBullets: true,
                        dynamicMainBullets: 10,
                        clickable: true
                    }
                }
            }
        },
        mounted() {
            console.log(this.films);
        }
    }
</script>

<style scope>
    .swiper-slide {
        width: auto;
        /*background-color: #444;*/
    }
    .swiper-pagination-bullet-active {
        background: #89023E;
    }

</style>
