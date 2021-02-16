<template>
    <div class="app">
        <div class="container">
            <input type="text" placeholder="Search for movies" v-model="search" @keydown.enter="SetSearch()">
            <div class="empty" v-if="this.currentSearch == ''">
                <h1> It's pretty empty here... </h1>
                <span> Quickly search for a movie to fill the void! </span>
            </div>
            <div class="loop-container">
                <div class="loop-item" v-for="(movie, id) in results.Search" :key="id">
                    <p style="color:white; margin-bottom: 2.5%"> {{ movie.Title }} </p>
                    <img :src="movie.Poster" @click="Details(movie.imdbID)" href=".app">
                </div>
            </div>
            <button @click="Pagination('prev')" :disabled="this.page == 1 || this.currentSearch == ''" class="slide prev" :class="this.page == 1 ? '' : 'colored'"> < </button>
            <button @click="Pagination('next')" :disabled="this.page == 100 || this.currentSearch == ''" class="slide next" :class="this.page == 100 ? '' : 'colored'"> > </button>
            <footer>
                <p> Page: {{ this.page }} of 100 </p>
            </footer>
        </div>

        <div class="details" :class="showDetails == true ? 'show' : 'hidden'">
            <div class="nav">
                <p class="close" @click="CloseDetails()"> X </p>
            </div>
            <div class="left">
                <img :src="details.Poster">
                <h3> {{ details.Title }} </h3>
            </div>
            <div class="right">
                <table border="0">
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
                        <td> {{ details.imdbRating }} </td>
                    </tr>
                    <tr>
                        <td> IMDB Votes </td>
                        <td> {{ details.imdbVotes }} </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data: function() {
            return {
                search: '',
                currentSearch: '',
                api: 'http://www.omdbapi.com/?apikey=94ec774b',
                results: [],
                page: 1,
                details: [],
                showDetails: false
            }
        },
        methods: {
            SetSearch() {
                this.currentSearch = this.search;
                this.page = 1;
                this.Search();
            },

             Pagination(button) {
                if (this.currentSearch == '') {
                    return;
                }

                if (button == 'prev') this.page--;
                if (button == 'next') this.page++;

                this.Search();
            },

            Search() {
                let url = this.api + '&s=' + this.currentSearch + '&page=' + this.page;

                fetch(url)
                .then(response => response.json())
                .then(callback => {
                    this.results = callback;
                })

                this.search = '';
            },

            Details(id) {
                this.showDetails = true;
                let url = this.api + '&i=' + id;

                fetch(url)
                .then(response => response.json())
                .then(callback => {
                    this.details = callback;
                })
            },

            CloseDetails() {
                this.showDetails = false;
                this.Search();
            }
        }
    }
</script>

<style scoped>
    * {
        padding: 0;
        margin: 0;
    }

    .app {
        width: 100%;
    }

    .details {
        position: absolute;
        top: 10%;
        left: 10%;
        width: 80%;
        height: 80vh;
        background-color: rgb(34, 34, 34);
        box-shadow: 15px 15px 20px black;
        overflow-y:hidden;
        overflow-x:hidden;
    }

    .show {
        display: initial;
    }

    .hidden {
        display: none;
    }

    .left {
        width: 50%;
        height: calc(100% - 90px);
        float: left;
        margin: 0 auto;
        padding-top: 5%;
        text-align: center;
    }

    .left img {
        width: 433px;
        height: 666px;
        box-shadow: 15px 15px 0px yellow;
    }

    .left h3 {
        margin-top: 5%;
        color: rgb(255, 0, 157);
        font-size: 40px;
        text-shadow: 3px 3px 0px black;
    }

    .right {
        width: 45%;
        height: calc(100% - 90px);
        float: left;
    }

    .right table {
        margin-top: 10%;
        font-size: 20px;
        color: rgb(189, 189, 189);
        border-collapse: collapse;
        box-shadow: 15px 15px 0px rgb(255, 0, 157);
    }

    .right table td {
        padding: 15px 30px;
    }

    .right table tr:nth-child(odd) {
        background-color: rgb(24, 24, 24);
    }
    .right table tr:nth-child(even) {
        background-color: rgb(41, 41, 41);
    }

    .right table td:first-child {
        color: rgb(114, 114, 114);
        font-weight: bold;
    }

    .nav {
        background-color: rgb(19, 19, 19);
        color: white;
        font-size: 50px;
        padding: 20px 30px;
        transition: 0.3s;
        height: 70px;
    }

    .close {
        float:right;
        color:white;
        font-size: 30px;
        opacity: 1;
    }

    .close:hover {
        color: yellow;
        cursor: pointer;
        transition: 0.2s;
    }

    /* DETAILSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSS ^^^^^^^^^^^^^^^^ */

    .container {
        width: 75%;
        height: 100vh;
        text-align: center;
        margin: 0 auto;
        /*background-color: #efefef;
        box-shadow: 5px 5px 10px rgb(185, 185, 185);*/
    }

    .container input[type=text] {
        width: 60%;
        margin: 3% auto 0 auto;
        padding: 15px 20px;
        font-size: 20px;
        outline: none;
        border: none;
        background-color: rgb(15, 15, 15);
        border-bottom: 3px black solid;
        color: rgb(255, 255, 197);
        transition: 0.3s;
    }

    .container .empty h1 {
        position: absolute;
        top: 40%;
        right: 26%;
        font-size: 110px;
        color: rgb(12, 12, 12);
    }

    .container .empty span {
        position: absolute;
        top: 53%;
        right: 39%;
        font-size: 30px;
        font-style:italic;
        color: rgb(12, 12, 12);
    }

    .container input[type=text]:hover {
        cursor: pointer;
        border-bottom: 3px yellow solid;
        transition: 0.2s;
    }

    .container input[type=text]:focus {
        cursor: pointer;
        border-bottom: 3px rgb(255, 0, 157) solid;
        box-shadow: 7px 7px 0px black;
        transition: 0.2s;
    }

    .container nav button {
        width: 7%;
        font-size: 14px;
        padding: 10px 20px;
    }

    .loop-container {
        width: 100%;
        margin: 3% auto;
    }

    .loop-item {
        margin: 20px 20px;
        display: inline-block;
    }

    .loop-item img {
        width: 300px;
        height: 444px;
        box-shadow: none;
        filter: grayscale(100%);
        transition: 0.3s;
    }

    .loop-item img:hover {
        transition: 0.1s;
        box-shadow: 15px 15px 0px rgb(255, 0, 157);
        filter: grayscale(0%);
        cursor: pointer;
    }

    footer {
        padding-bottom: 25px;
        position: absolute;
        bottom: 3%;
        left: 48%;
        color: rgb(175, 175, 175);
        font-style: italic;
    }

    .slide {
        border: none;
        outline: none;
        font-size: 25px;
        font-weight: bold;
        background-color: rgb(255, 0, 157);
        width: 50px;
        height: 50px;
        border-radius: 50%;
        box-shadow: 5px 5px 0px black;
    }

    .colored {
        color: yellow;
        transition: 0.3s;
    }

    .colored:hover {
        color: black;
        background-color: yellow;
        transition: 0.1s;
        cursor: pointer;
    }

    :disabled {
        background-color: rgb(255, 0, 157);
    }

    .prev {
        position: absolute;
        top: 47.5%;
        left: 14%;
    }

    .next {
        position: absolute;
        top: 47.5%;
        right: 14%;
    }
</style>
