<template>
    <div class="search-components">
        <form>
            <input type="text" class="search" v-model="keywords">
        </form>
        <a href="#">Расширенный поиск</a>
        <ul v-if="movies.length > 0" class="search unstyled">
            <li v-for="movie in movies" :key="movie.id" v-text="movie.title"></li>
        </ul>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                keywords: '',
                movies: []
            }
        },
        watch: {
            keywords(after, before) {
                this.fetch();
            }
        },
        methods: {
            fetch() {
                axios.get('/api/search/movies', {params: {keywords: this.keywords}})
                        .then(response => {
                            this.movies = response.data
                        })
                        .catch(error => {
                        });
            }
        }
    }
</script>