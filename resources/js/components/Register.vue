<template>
    <div>
        <navigation></navigation>
        <div class="container mx-auto py-2">
            <div class="flex flex-wrap w-full justify-center items-center pt-56">
                <div class="flex flex-wrap max-w-xl">
                    <div class="p-2 text-2xl text-gray-800 font-semibold"><h1> Register an account </h1></div>
                    <div class="p-2 w-full">
                        <label class="w-full" for="name"> Name </label>
                        <span class="w-full text-red-500" v-if="errors.name"> {{ errors.name[0] }} </span>
                        <input class="w-full bg-gray-100 rounded border border-gray-400 focus:outline-none focus:border-indigo-500 text-base px-4 py-2" placeholder="Name" type="text" v-model="form.name">
                    </div>
                    <div class="p-2 w-full">
                        <label class="w-full" for="name"> Email </label>
                        <!-- <span class="w-full text-red-500" v-if="errors.name"> {{ errors.name[0] }} </span> -->
                        <input class="w-full bg-gray-100 rounded border border-gray-400 focus:outline-none focus:border-indigo-500 text-base px-4 py-2" placeholder="Email" type="email" v-model="form.email">
                    </div>
                    <div class="p-2 w-full">
                        <label class="w-full" for="name"> Password </label>
                        <!-- <span class="w-full text-red-500" v-if="errors.name"> {{ errors.name[0] }} </span> -->
                        <input class="w-full bg-gray-100 rounded border border-gray-400 focus:outline-none focus:border-indigo-500 text-base px-4 py-2" placeholder="Password" name="password" type="password" v-model="form.password">
                    </div>
                    <div class="p-2 w-full">
                        <label class="w-full" for="name"> Confirm password </label>
                        <!-- <span class="w-full text-red-500" v-if="errors.name"> {{ errors.name[0] }} </span> -->
                        <input class="w-full bg-gray-100 rounded border border-gray-400 focus:outline-none focus:border-indigo-500 text-base px-4 py-2" placeholder="Confirm password" name="password_confirmation" type="password" v-model="form.password_confirmation">
                    </div>
                    <div class="p-2 w-full mt-4">
                        <button @click.prevent="Register()" type="submit" class="flex text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg"> Register </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import navigation from './Nav.vue';

    export default {
        components: {
            navigation
        },
        data() {
            return {
                form: {
                    name: '',
                    email: '',
                    password: '',
                    password_confirmation: ''
                },
                errors: []
            }
        },
        methods: {
            Register() {
                // Register the user and redirect to the login screen
                axios.post('api/register ', this.form).then((response) => {
                    this.$router.push({ name: "Login" });
                }).catch((error) => {
                    this.errors = error.response.data.errors;
                })
            }
        }
    }
</script>
