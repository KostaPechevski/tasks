<template>
    <div>
        <h3 class="text-center">Create Task</h3>
        <div class="row">
            <div v-for="(errorArray, index) in errors" :key="index">
                <span class="text-danger">{{ errorArray[0]}} </span>
            </div>
            <div class="col-md-6">
                <form @submit.prevent="addTask">
                    <div class="form-group">
                        <label>Title</label>
                        <input type="text" class="form-control" v-model="task.title">
                    </div>
                    <div class="form-group">
                        <label>Expiration date</label>
                        <input type="date" class="form-control"  :min="task.expiration_data" v-model="task.expiration_data">
                    </div>
                    <div class="form-group">
                        <label>Description</label>
                        <textarea class="form-control" v-model="task.description"/>
                    </div>
                    <div class="form-group">
                        <label>State</label>
                        <select class="form-control" v-model="task.state">
                            <option v-for="option in options" :value="option.value">
                                {{ option.text }}
                            </option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Create</button>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
import moment from 'moment';

export default {
    data() {
        return {
            task: {
                'expiration_data': new Date().toISOString().slice(0,10)
            },
            options: [
                { text: 'Open', value: 'open' },
                { text: 'Completed', value: 'completed' },
                { text: 'Cancelled', value: 'cancelled' }
            ],
            errors: ''
        }
    },

    methods: {
        format_date(){
            return moment(String(new Date())).format('DD-MMM-YYYY')
        },
        addTask() {
            axios.post('/api/tasks', this.task)
                .then(response => (
                    this.$router.push({ name: 'all-tasks' })
                ))
                .catch(e => {
                    this.errors = e.response.data.errors
                })
        }
    }
}
</script>
