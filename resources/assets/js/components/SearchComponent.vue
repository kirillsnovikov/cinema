<template>
    <div class="search-components">
        <input type="text" class="search" v-model.trim="keywords" placeholder="Быстрый поиск">
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
            time: null,
            keywords: '',
            movies: [],
            error: false
        }
    },
    watch: {
        keywords: function (keywords) {
            if (keywords.length >= 0) {
                if (this.time) {
                    clearTimeout(this.time);
                }
                this.time = setTimeout(() => this.fetch(keywords), 500);
            }
        }
    },
    methods: {
        fetch(keywords) {
            this.error = false;
            if (keywords == '') {
                this.movies = [];
                console.log('пусто');
            } else if (keywords.length < 2) {
                this.movies = [];
                this.error = 'Введите хотя-бы два символа';
                console.log(this.error);
            } else {
                console.log(keywords);
                axios.get('/api/search/movies', {params: {keywords: keywords}})
                .then(response => {
                    this.movies = response.data
                    if(this.movies.length == 0) {
                        this.error = 'Упс! По вашему запросу ничего не найдено!'
                    }
                })
                .catch(error => {
                });
            }
        }
    }
}
</script>