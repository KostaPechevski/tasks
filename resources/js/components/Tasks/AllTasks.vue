<template>
    <div>
        <h2 class="text-center">Tasks List</h2>

        <table class="table">
            <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Expiration date</th>
                <th>Description</th>
                <th>State</th>
                <th>User</th>
                <!-- <th>Actions</th> -->
            </tr>
            </thead>
            <tbody>
            <tr v-for="task in tasks" :key="task.id">
                <td>{{ task.id }}</td>
                <td>{{ task.title}}</td>
                <td>
                    <div v-show = "!editDate">
                        <label @click = "editDate = true"> {{ task.expiration_data }}</label>
                    </div>
                    <input v-show = "editDate == true"
                           type="date"
                           :min="task.expiration_data"
                           v-model = "task.expiration_data"
                           v-on:blur= "editDate=false; updateTask(task.id, task.expiration_data)"
                           @keyup.enter = "editDate=false; updateTask(task.id, task.expiration_data)">
                </td>
                <td>{{ task.description }}</td>
                <td>{{ task.state }}</td>
                <td>{{ task.user.name }}</td>
                <td>
                    <div class="btn-group" role="group">
                        <button class="btn btn-danger" @click="deleteTask(task.id)">Delete</button>
                    </div>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
export default {
    data() {
        return {
            tasks: [],
            editDate: false
        }
    },
    created() {
        axios.get('/api/tasks')
            .then(response => {
                this.tasks = response.data;
            });
    },
    methods: {
        updateTask(task_id, date) {
            axios.patch(`/api/tasks/${task_id}`, {
                'expiration_date' : date
            })
                .then((res) => {
                    console.log(res)
                })
        },
        deleteTask(id) {
            axios.delete(`/api/tasks/${id}`)
                .then(response => {
                    let i = this.tasks.map(data => data.id).indexOf(id);
                    this.tasks.splice(i, 1)
                });
        }
    }
}
</script>
