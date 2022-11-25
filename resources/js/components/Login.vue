<template>
    <div>
        <div class="d-flex flex-column">
            <div class="p-2"><h1>Login to your account</h1></div>
            <div>
                <div class="p-2 ">
                    <label for="email">Your username</label>
                    <input class="" placeholder="Username" type="email" v-model="form.username" name="username">
                </div>
                <div class="p-2 ">
                    <label for="password">Password</label>
                    <input class="" placeholder="Password" type="password" v-model="form.password" name="password">
                </div>
                <div class="p-2  mt-4">
                    <button @click.prevent="loginUser" type="submit" class="">Login</button>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    name: 'Login',
    data(){
        return{
            form:{
                username: '',
                password: ''
            },
            errors: []
        }
    },
    methods:{
        loginUser(){
            axios.post('/api/login', this.form)
                .then(() =>{
                    window.location.reload()
                })
                .catch((error) =>{
                this.errors = error.response.data.errors;
            })
        }
    },

}
</script>
