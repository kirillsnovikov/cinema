<template>
    <div>
        <input type="text" v-model.trim="search">
        <div>{{search}}</div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                search: '',
                searchUpdate: '',
                time: null,
            }
        },
        watch: {
            search: function (search) {
                var self = this;
                console.log('Search keypress: ' + search);
                if (search.length >= 0) {
                    if (this.time) {
                        clearTimeout(this.time);
                    }
                    this.time = setTimeout(() => this.searchOnline(search), 5000);
                    console.log('Search online or wait user finish word?');
                }
            },
        },
        methods: {
            searchOnline: function (search) {
                console.log('Start search online: ' + search);
                this.searchUpdate = search;
                // axios call api search endpoint
                console.log('Serch online finished!', this.searchUpdate);
            },
        }
    }
</script>
