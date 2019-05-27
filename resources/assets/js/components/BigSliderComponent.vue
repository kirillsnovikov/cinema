<template>
    <!-- swiper -->
    <swiper :options="swiperOption">
        <swiper-slide v-for="(film, index) in 10" :key="index">
            <img :src="'https://loremflickr.com/1280/266/art/?random=' + index" 
                :alt="'Постер к фильму'" 
                :title="'Постер к фильму'" width="100%">
        </swiper-slide>
        <div class="swiper-pagination" slot="pagination"></div>
        <!--<div class="swiper-button-prev" slot="button-prev"></div>-->
        <!--<div class="swiper-button-next" slot="button-next"></div>-->
    </swiper>
</template>

<script>
    export default {
        data() {
            return {
                swiperOption: {
                    loop: true,
                    pagination: {
                        el: '.swiper-pagination',
//                        type: 'progressbar',
//                        dynamicBullets: true,
//                        dynamicMainBullets: 10,
                        clickable: true
                    }
                }
            }
        },
        mounted() {
            console.log('asdfasdf');
        }
    }
</script>
