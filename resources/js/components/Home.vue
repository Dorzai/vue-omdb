<template>
    <div>
        <navigation></navigation>
        <div class="container mx-auto py-2">
            <input class="w-full bg-gray-100 rounded border border-gray-400 focus:outline-none focus:border-indigo-500 text-base px-4 py-2 my-5" placeholder="Titanic" type="text" v-model="search" @keydown.enter="Search()">
            <div class="flex items-center justify-center flex-wrap">
                <div v-for="(movie, id) in movies.Search" :key="id">
                    <div @click="Details(movie.imdbID)">
                        <img class="my-2 mx-1 movie-size rounded card" :src="movie.Poster">
                        <p class="flex items-center justify-center"> {{ movie.Title }} </p>
                        <p class="flex items-center justify-center"> {{ movie.Year }} </p>
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
                            <td> Id </td>
                            <td> {{ details.imdbID }} </td>
                        </tr>
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
                            <td class="py-4"> <button @click.prevent="Add(details.imdbID, details.Poster, details.Title, details.Year)" type="submit" :class="user == null ? 'hidden' : 'block'" class="flex text-white bg-indigo-500 border-0 mr-4 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg"> Favorite </button> </td>
                            <td class="py-4"> <button @click.prevent="Details()" type="submit" class="flex text-white bg-indigo-500 border-0 mr-4 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg"> Close </button> </td>
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
                search: '',
                movies: '',
                view: false,
                user: null,
                details: '',
                mov: '',
                favorite: {
                    movie_id: '',
                    poster: '',
                    title: '',
                    year: '',
                },
                api: 'http://www.omdbapi.com/?apikey=94ec774b',
            }
        },
        methods: {
            Search() {
                let url = this.api + '&s=' + this.search;

                fetch(url)
                .then(response => response.json())
                .then(callback => {
                    this.movies = callback;
                })

                this.search = '';
            },
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
            Add(movie_id, poster, title, year) {
                // Put the parameters in the array
                this.favorite.movie_id = movie_id;
                this.favorite.poster = poster;
                this.favorite.title = title;
                this.favorite.year = year;

                // Store the data
                axios.post('api/favorites/store', {
                    favorite: this.favorite
                })
                .then(response => {
                    if (response.status == 201) {
                        this.view = false // Close the modal
                    }
                })
                .catch(error => {
                    console.log(error)
                });
            }
        },
        mounted() {
            // Get the user
            axios.get('/api/user').then((response) => {
                this.user = response.data
            });

            let url = this.api + '&s=Titanic';

            // Get a default movie
            fetch(url)
            .then(response => response.json())
            .then(callback => {
                this.movies = callback;
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
