<template>
    <div class="search-components">
        <form>
            <input type="text" class="search" v-model.trim="keywords" placeholder="Быстрый поиск">
        </form>
        <a class="small" href="#">Расширенный поиск</a>
        <ul v-if="error" class="search unstyled">
            <li class="small color">{{error}}</li>
        </ul>
        <ul v-if="movies.length > 0" class="search unstyled">
            <li class="small" v-for="movie in movies" :key="movie.id">
                <a :href="route + '/' + movie.slug">
                    <time>{{movie.premiere}}</time>
                    <div class="search-title">
                        <span>{{movie.title}}</span>
                        <br>
                        <span class="cursive">{{movie.title_en}}</span>
                    </div>
                    <img :src="'https://loremflickr.com/30/45/art/?random=' + movie.image" 
                        :alt="'Постер к фильму ' + movie.title" 
                        :title="'Постер к фильму ' + movie.title">
                </a>
            </li>
        </ul>
    </div>
</template>

<script>
    export default {
        props: [
            'route'
        ],
        data() {
            return {
                keywords: '',
                movies: [],
                error: false
            }
        },
        watch: {
            keywords(after, before) {
                this.fetch();
                console.log('Prop changed: ', after, ' | was: ', before);
            }
        },
        methods: {
            fetch() {
                var v = this;
                setTimeout(function () {
                    v.error = false;
                    if (v.keywords == '') {
                        v.movies = [];
                    } else if (v.keywords.length < 2) {
                        v.error = 'Введите хотя-бы два символа';
                        console.log(v.keywords.length);
                    } else {
                        axios.get('/api/search/movies', {params: {keywords: v.keywords}})
                                .then(response => {
                                    v.movies = response.data
                                })
                                .catch(error => {
                                });
                    }
                }, 1200);
            }
        }
    }
</script>