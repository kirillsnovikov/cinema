<template>
    <div class="container">
        <div class="row">
            <div class="col">
                <h1>{{movie.title}}</h1>
                <img :src="'https://loremflickr.com/300/400/art/?random=' + movie.image_name" class="img-fluid" :alt="'Постер к фильму ' + movie.title" :title="'Постер к фильму ' + movie.title" />
                <p>{{movie.description}}</p>
                <hr>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: [
            'id'
        ],
        data: function () {
            return {
                movie: Object,
                error: {
                    type: Boolean,
                    default: false
                },
                loading: true
            }
        },
        mounted() {
            console.log(this.id)
            axios.get('/api/movies/' + this.id)
            .then(response => (this.movie = response.data))
            .catch(error => {
                this.error = true;
            })
            .finally(() => (this.loading = false));
        },
        methods: {
            movieApiRequest() {
                return axios.get('/api/movies')
            },
            moonwalkVideoRequest() {
                return axios.get('http://moonwalk.cc/api/videos.json', {
                    params: {
                        kinopoisk_id: 11025031,
                        api_token: this.token
                    }
                })
            }
        }
    }
</script>
