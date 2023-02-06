<template>
    <div class="d-flex">
        <h3>Login</h3>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <router-link :to="{name: 'user.register'}">
            <h3 class="register">Register</h3>
        </router-link>

    </div>

    <div class="w-25 mt-3">
        <input v-model="email" class="form-control mb-2" type="email" placeholder="Email">
        <input v-model="password" class="form-control mb-2" type="password" placeholder="Password">
        <div class="text-danger" v-if="error">{{ this.error }}</div>
        <input @click.prevent="login" class="btn btn-outline-primary" type="submit" value="Login">
    </div>
</template>

<script>
import axios from "axios";
import router from "../../router";

export default {
    name: "Login",

    data() {
        return {
            email: '',
            password: '',
            error: '',
        }
    },

    methods: {
        login() {
            axios.post('/api/auth/login', {
                email: this.email,
                password: this.password,
            }).then(response => {
                console.log(response);
                localStorage.access_token = response.data.token;
                router.push({name: 'tasks.index'});
            }).catch(error => {
                this.error = error.response.data.error;
            })
        }
    }
}
</script>

<style scoped>
.register{
    color: lightgray;
}

a {
    text-decoration: none;
}
</style>
