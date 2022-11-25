<template>
    <div class="d-flex align-items-baseline justify-content-evenly">

        <p>Name: {{user.name}}</p>
        <p>Username: {{user.username}}</p>
        <div class="p-2 mt-4">
            <button @click.prevent="logoutUser" type="submit" class="">Logout</button>
        </div>
    </div>
</template>
<script>
export default {
    name: 'Logout',
    props: ['user'],
    methods: {
        logoutUser() {
            axios.get("/api/logout")
                .then(() =>{
                    window.location.reload()
                })
                .catch(error => {
                    console.log(error);
                });
        }
    }


}
</script>
