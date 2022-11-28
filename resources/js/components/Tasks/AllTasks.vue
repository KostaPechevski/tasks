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
            <tr v-for="(task, key) in tasks" :key="task.id">
                <td>{{ task.id }}</td>
                <td>{{ task.title}}</td>
                <td>
                    <div v-show = "!task.editDate">
                        <label @click = "task.editDate = true; editDateGlobal = key"> {{ task.expiration_data }}</label>
                    </div>
                    <input v-show = "task.editDate == true"
                           type="date"
                           :min="task.expiration_data"
                           v-model = "task.expiration_data"
                           v-on:blur= "task.editDate=false; updateTask(task.id, task.expiration_data)"
                           @keyup.enter = "task.editDate=false; updateTask(task.id, task.expiration_data)">
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
        <span class="text-danger">{{ error }} </span>
        <span class="text-success">{{ success }} </span>
    </div>
</template>

<script>
export default {
    data() {
        return {
            tasks: [],
            editDateGlobal: null,
            error: '',
            success: '',
        }
    },
    created() {
        this.getTasks()
    },
    watch: {
        editDateGlobal: function(newVal, oldVal) {
            if (oldVal != null) {
                this.tasks[oldVal].editDate = false
            }
        }
    },
    methods: {
        getTasks() {
            axios.get('/api/tasks')
                .then(response => {
                    this.tasks = response.data;
                });
        },
        updateTask(task_id, date) {
            axios.patch(`/api/tasks/${task_id}`, {
                'expiration_date' : date
            })
                .then((res) => {
                    if (res.data.status == 'error') {
                        this.error = res.data.message
                        this.success = ''
                        this.tasks.forEach((task, index) => {
                            if (task.id == task_id) {
                                task.editDate = true
                            }
                        });
                    } else {
                        this.error = ''
                        this.success = res.data
                    }
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
