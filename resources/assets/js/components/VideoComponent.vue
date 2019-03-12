<template>
    <div class="container">
        <div class="row">
            <div class="col">
                <div style="width: 610px; height: 370px;" class="bg-dark overflow-auto">
                    <div class="alert alert-danger m-1" v-if="error">
                        К сожалению, в настоящее время мы не можем получить это видео. Пожалуйста, повторите попытку позже.
                    </div>
                    <div v-else class="h-100 d-flex align-items-center justify-content-center">
                        <div v-if="loading">
                            <div class="spinner-border text-info" role="status">
                                <span class="sr-only">Loading...</span>
                            </div>
                        </div>
                        <iframe v-else :src="video" class="position-relative w-100 h-100" frameborder="0" allowfullscreen></iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: [
            'token',
            'kpId'
        ],
        data: function () {
            return {
                video: null,
                error: false,
                loading: true
            }
        },
        mounted() {
            console.log(this.token),
                    console.log(this.kpId),
                    axios
                    .get('http://moonwalk.cc/api/videos.json', {
                        params: {
                            kinopoisk_id: 11025031,
                            api_token: this.token
                        }
                    })
                    .then(response => (this.video = response.data[0].iframe_url))
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
