<template>
    <div class="d-flex">
        <h3>Register</h3>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <router-link :to="{name: 'user.login'}">
            <h3 class="login">Login</h3>
        </router-link>
    </div>
    <div class="w-25 mt-3">
        <input v-model="name" class="form-control mb-2" type="text" placeholder="Name">
        <input v-model="email" class="form-control mb-2" type="email" placeholder="Email">
        <div class="text-danger" v-if="error">{{ this.error }}</div>
        <input v-model="password" class="form-control mb-2" type="password" placeholder="Password">
        <input v-model="password_confirmation" class="form-control mb-2" type="password" placeholder="Confirm Password">
        <input @click.prevent="store" class="btn btn-outline-primary" type="submit" value="Sign Up">
    </div>
</template>

<script>
import Login from "./Login.vue";

export default {
    name: "Registration",
    components: {Login},

    data() {
        return {
            name: '',
            email: '',
            password: '',
            password_confirmation: null,
            error: '',
        }
    },

    methods: {
        store() {
            axios.post('/api/auth/register', {
                name: this.name,
                email: this.email,
                password: this.password,
                password_confirmation: this.password_confirmation,
            }).then(response => {
                localStorage.access_token = response.data.token;
                this.$router.push({name: 'tasks.index'});
            }).catch(error => {
                this.error = error.response.data.error;
            })
        }
    }
}
</script>

<style scoped>
.login {
    color: lightgray;
}

a {
    text-decoration: none;
}
</style>
