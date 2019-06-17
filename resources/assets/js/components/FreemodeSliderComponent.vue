<template>
    <!-- swiper -->
    <swiper :options="swiperOption">
        <div v-if="loading">
            <div class="spinner-border text-info" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <swiper-slide v-else v-for="(video, index) in videos" :key="index">
            <div class="card">
                <a :href="route + '/' + video.slug">
                    <div class="card-poster">
                        <img :src="'https://loremflickr.com/250/375/art/?random=' + video.image" 
                            :alt="'Постер к фильму ' + video.title" 
                            :title="'Постер к фильму ' + video.title">
                    </div>
                    <div class="card-title">{{video.title}}</div>
                </a>
                <div class="card-raiting">{{video.kp_raiting | raiting}}</div>
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
            'videos',
            'route'
        ],
        data() {
            return {
                loading: true,
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
        filters: {
            raiting(value) {
                let raiting = value / 10000;
                return raiting.toFixed(1);
            }
        },
        mounted() {
            console.log(this.loading);
            this.$nextTick(function () {
                this.loading = false;
                console.log(this.loading);
            });
            
            // this.loading = false;
        }
    }
</script>

<style>
    .spinner-border {
        width: 1000px;
        height: 375px;
        background-color: #F63E02;
    }
</style>
