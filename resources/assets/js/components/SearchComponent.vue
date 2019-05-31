<template>
    <div class="search-components">
        <form>
            <input type="text" class="search" v-model="keywords" placeholder="Быстрый поиск">
        </form>
        <a href="#">Расширенный поиск</a>
        <ul v-if="error" class="search unstyled">
            <li>{{error}}</li>
        </ul>
        <ul v-if="movies.length > 0" class="search unstyled">
            <li v-for="movie in movies" :key="movie.id">
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
            this.error = false;
            this.movies = [];
            if (this.keywords.trim() == '') {
                this.movies = [];
            } else if (this.keywords.trim().length <= 2) {
                this.error = 'Введите больше двух символов';
                console.log(this.keywords.trim().length);
            }
            else {
                axios.get('/api/search/movies', {params: {keywords: this.keywords.trim()}})
                .then(response => {
                    this.movies = response.data
                })
                .catch(error => {
                });
            }
        }
    }
}
</script>