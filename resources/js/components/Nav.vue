<template>
    <div class="flex bg-gray-100 border-gray-300 py-4">
        <div class="container mx-auto flex ">
            <router-link class="mr-4" to="/" exact> Home </router-link>
            <router-link class="mr-4" v-if="user != null" to="/favorites"> Favorites </router-link>
            <router-link class="mr-4" v-if="user != null" to="/logout"> Logout </router-link>
            <router-link class="mr-4" v-if="user == null" to="/login" > Login </router-link>
            <router-link class="mr-4" v-if="user == null" to="/register"> Register </router-link>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                user: null
            }
        },
        mounted() {
            axios.get('/api/user').then((response) => {
                this.user = response.data
            });
        }
    }
</script>
