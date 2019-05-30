<template>
    <div class="search-components">
        <form>
            <input type="text" class="search" v-model="keywords">
            <button>{{keywords}}</button>
        </form>
        <a href="#">Расширенный поиск{{movies}}</a>
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