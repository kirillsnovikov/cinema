<template>
    <!-- swiper -->
    <swiper :options="swiperOption">
        <swiper-slide>
            <div class="card" style="width: 18rem;">
                <img src="https://loremflickr.com/250/100/art/?random=1" class="card-img-top" alt="sdfgsdfg">
                <div class="card-body">
                    <h5 class="card-title">Card title</h5>
                    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                    <a href="#" class="btn btn-primary">Go somewhere</a>
                </div>
            </div>
        </swiper-slide>
        <swiper-slide>Slide 2</swiper-slide>
        <swiper-slide>Slide 3</swiper-slide>
        <swiper-slide>Slide 4</swiper-slide>
        <swiper-slide>Slide 5</swiper-slide>
        <swiper-slide>Slide 6</swiper-slide>
        <swiper-slide>Slide 7</swiper-slide>
        <swiper-slide>Slide 8</swiper-slide>
        <swiper-slide>Slide 9</swiper-slide>
        <swiper-slide>Slide 10</swiper-slide>
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
                    slidesPerView: 'auto',
                    spaceBetween: 30,
                    freeMode: true,
                    pagination: {
                        el: '.swiper-pagination',
                        clickable: true
                    }
                }
            }
        }
    }
</script>

<style scope>
    .swiper-slide {
        width: 150px;
        background-color: #444;
    }

</style>
