<template>
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="">
                <div class="navbar-nav">
                    <router-link to="/tasks" class="nav-item nav-link">Tasks List</router-link>
                    <router-link to="/create" class="nav-item nav-link">Create Task</router-link>
                </div>
            </div>
        </nav>
        <router-view> </router-view>
    </div>
</template>

<script>
export default {
    name: 'Tasks',
}
</script>
