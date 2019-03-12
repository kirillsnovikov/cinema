<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card card-default" v-if="loading">
                    <div class="card-header">{{movies.title}}</div>
                    <div class="card-body">{{JSON.stringify(persons) ? persons.Name + ' ' + persons.LastName : ''}}</div>
                </div>
            </div>
        </div>
    </div>
</template>





<script>
    export default {
        data: () => ({
           movies: Object,
           persons: Object,
           loading: {
                type: Boolean,
                default: false
           }
        }),
        mounted() {
            Promise.all([
                axios.get('/api/movies'),
                axios.get('/api/persons')
            ]).then(([
                    movies,
                    persons
                    ]) => {
                console.log(movies.data[0], persons.data[0]),
                this.movies = movies.data[0],
                this.persons = persons.data[0]
                
                ///
            })
            .finally(() => (this.loading = true));
        }
    }
</script>


<!--<script>
    export default {
        data: () => ({
           movies: null,
           persons: null
        }),
        mounted() {
            axios.all([
                axios.get('/api/movies'),
                axios.get('/api/persons')
            ])
            .then(axios.spread(function (movies, persons) {
                console.log(movies.data, persons.data),
                movies = movies.data,
                persons = persons.data
            }));
            .then(axios.spread(([
                    movies,
                    persons
                    ]) => {
                console.log(movies.data, persons.data),
                this.movies = movies.data,
                this.persons = persons.data
                
                ///
            }));
        }
    }
</script>-->
