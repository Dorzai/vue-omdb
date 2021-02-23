<template>
    <div>
        <navigation></navigation>
        <div class="container mx-auto py-2">
            <!-- <input class="w-full bg-gray-100 rounded border border-gray-400 focus:outline-none focus:border-indigo-500 text-base px-4 py-2 my-5" placeholder="Titanic" type="text" v-model="search" @keydown.enter="Search()"> -->
            <div class="flex items-center justify-center flex-wrap">
                <div v-for="(favorite, id) in favorites" :key="id">
                    <div @click="Details(favorite.movie_id)">
                        <img class="my-2 mx-1 movie-size rounded card" :src="favorite.poster">
                        <p class="flex items-center justify-center"> {{ favorite.title }} </p>
                        <p class="flex items-center justify-center"> {{ favorite.year }} </p>
                    </div>
                </div>
            </div>
            <div class="absolute inset-0 bg-gray-900 flex items-center justify-center opacity-60" :class="view ? 'block' : 'hidden'"></div>
            <div class="w-8/12 h-4/5 flex inset-0 absolute bg-gray-100 rounded mx-auto my-auto shadow" :class="view ? 'block' : 'hidden'">
                <div class="w-4/12 py-4 px-4 mx-auto flex items-center justify-center">
                    <img class="my-2 mx-1 movie-size rounded" :src="details.Poster">
                </div>
                <div class="w-8/12 py-4 px-4 mx-auto flex items-center justify-center">
                    <table border="0" class="float-left">
                        <tr>
                            <td> Actors </td>
                            <td> {{ details.Actors }} </td>
                        </tr>
                        <tr>
                            <td> Director </td>
                            <td> {{ details.Director }} </td>
                        </tr>
                        <tr>
                            <td> Production </td>
                            <td> {{ details.Production }} </td>
                        </tr>
                        <tr>
                            <td> Box office </td>
                            <td> {{ details.BoxOffice }} </td>
                        </tr>
                        <tr>
                            <td> Country </td>
                            <td> {{ details.Country }} </td>
                        </tr>
                        <tr>
                            <td> Language </td>
                            <td> {{ details.Language }}</td>
                        </tr>
                        <tr>
                            <td> Genre </td>
                            <td> {{ details.Genre }} </td>
                        </tr>
                        <tr>
                            <td> Plot </td>
                            <td> {{ details.Plot }} </td>
                        </tr>
                        <tr>
                            <td> Released </td>
                            <td> {{ details.Released }} </td>
                        </tr>
                        <tr>
                            <td> Runtime </td>
                            <td> {{ details.Runtime }} </td>
                        </tr>
                        <tr>
                            <td> Awards </td>
                            <td> {{ details.Awards }} </td>
                        </tr>
                        <tr>
                            <td> Rated </td>
                            <td> {{ details.Rated }} </td>
                        </tr>
                        <tr>
                            <td> Metascore </td>
                            <td> {{ details.Metascore }} </td>
                        </tr>
                        <tr>
                            <td> IMDB Rating </td>
                            <td> {{ details.imdbRating }} from {{ details.imdbVotes }} votes </td>
                        </tr>
                        <tr>
                            <td class="py-4"> <button @click.prevent="Remove(details.imdbID)" type="submit" class="flex text-white bg-indigo-500 border-0 mr-4 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg"> Remove </button> </td>
                            <td class="py-4"> <button @click.prevent="Details(details.imdbID)" type="submit" class="flex text-white bg-indigo-500 border-0 mr-4 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg"> Close </button> </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <bottom></bottom>
    </div>
</template>

<script>
    import navigation from './Nav.vue';
    import details from './Details.vue';
    import bottom from './Footer.vue';

    export default {
        components: {
            navigation,
            details,
            bottom
        },
        data() {
            return {
                user: null,
                favorites: '',
                details: '',
                view: false,
                api: 'http://www.omdbapi.com/?apikey=94ec774b',
            }
        },
        methods: {
            Details(id) {
                // Open and/or close modal
                this.view = (this.view) ? false : true;
                if (this.view) {
                    // Open the modal
                    document.body.classList.add('modal-open');
                    window.scrollTo(0, 0);

                    let url = this.api + '&i=' + id;

                    // Get the details content
                    fetch(url)
                    .then(response => response.json())
                    .then(response => {
                        this.details = response;
                    })
                }
                else
                    document.body.classList.remove('modal-open'); // Remove the modal
            },
            Remove(movie_id) {
                // Delete request
                axios.delete('api/favorites/' + movie_id, {
                })
                .then(response => {
                    if (response.status == 200) {
                        this.view = false // Close the modal

                        // Refresh the favorites list
                        axios.get('/api/favorites/list/' + this.user.id).then((response) => {
                            this.favorites = response.data
                        });
                    }
                })
                .catch(error => {
                    console.log(error)
                });
            }
        },
        mounted() {
            // Get the user and all the movies they favorited
            axios.get('/api/user').then((response) => {
                this.user = response.data,
                axios.get('/api/favorites/list/' + this.user.id).then((response) => {
                    this.favorites = response.data
                });
            });

        }
    }
</script>

<style>
    .movie-size {
        width: 290px;
        height: 400px;
    }

    .card {
        transition: 0.2s;
    }

    .card:hover {
        cursor: pointer;
        box-shadow: 5px 5px 10px rgb(71, 71, 71);
        transition: 0.3s;
    }

    .shadow {
        box-shadow: 5px 5px 10px rgb(24, 24, 24);
    }

    .modal-open {
        overflow-y: hidden !important;
        overflow-x: hidden !important;
    }
</style>
