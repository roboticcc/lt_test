<template>
    <table class="table">
        <thead>
        <tr>
            <th scope="col">Title</th>
            <th scope="col">Content</th>
            <th scope="col">Actions</th>
        </tr>
        </thead>
        <tbody>
        <template v-for="task in tasks">
            <tr>
                <td>{{ task.title }} {{ task.id }}</td>
                <td>{{ task.content }}</td>
                <td>
                    <button v-if="task.completed === 'false'" @click.prevent="markTaskCompleted(task.id)"
                            class="btn btn-success mb-3">&#10003;
                    </button>
                    <button @click.prevent="replaceTask(task.id)" class="btn btn-danger reload">&#x21bb;</button>
                </td>
            </tr>
        </template>
        </tbody>
    </table>
    <div class="d-flex justify-content-center">
        <button @click.prevent="logOut" class="btn btn-outline-danger">Logout</button>
    </div>
</template>

<script>
import axios from "axios";

export default {
    name: "Index",

    data() {
        return {
            tasks: {},
        }
    },

    mounted() {
        this.getTasks()
    },

    methods: {
        getTasks() {
            axios.get('/api/v1/tasks', {
                headers: {
                    'authorization': `Bearer ${localStorage.access_token}`
                }
            }).then(response => {
                this.tasks = response.data.data;
                this.$router.push({name: 'tasks.index'})
            })
        },
        replaceTask(id) {
            axios.post(`/api/v1/tasks/${id}/replace`, {}, {
                headers: {
                    'authorization': `Bearer ${localStorage.access_token}`
                }
            }).then(response => {
                this.getTasks();
            })
        },
        markTaskCompleted(id) {
            axios.post(`/api/v1/tasks/${id}/submit`, {}, {
                headers: {
                    'authorization': `Bearer ${localStorage.access_token}`
                }
            }).then(response => {
                this.getTasks();
            });
        },
        logOut() {
                    localStorage.removeItem('access_token');
                    this.$router.push({name: 'user.login'});
        }
    }
}
</script>

<style scoped>
.reload {
    font-family: Lucida Sans Unicode
}
</style>
