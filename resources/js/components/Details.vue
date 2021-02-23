<template>
    <div>

    </div>
</template>

<script>
    export default {
        methods: {
            Details(id) {
                this.view = (this.view) ? false : true;
                if (this.view) {
                    document.body.classList.add('modal-open');
                    window.scrollTo(0, 0);

                    let url = this.api + '&i=' + id;

                    fetch(url)
                    .then(response => response.json())
                    .then(response => {
                        this.details = response;
                    })
                }
                else
                    document.body.classList.remove('modal-open');
            },
            Add(movie_id, poster, title, year) {
                this.favorite.movie_id = movie_id;
                this.favorite.user_id = this.user.id;
                this.favorite.poster = poster;
                this.favorite.title = title;
                this.favorite.year = year;

                axios.post('api/favorites/store', {
                    favorite: this.favorite
                })
                .then(response => {
                    if (response.status == 201) {
                        this.view = false
                    }
                })
                .catch(error => {
                    console.log(error)
                });
            }
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
