<template>
    <div>
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">Name</label>
            <input type="email" class="form-control" v-model="user.name" id="exampleInputName">
        </div>
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">Email address</label>
            <input type="email" class="form-control" v-model="user.email" id="exampleInputEmail1" aria-describedby="emailHelp">
        </div>
        <div class="mb-3">
            <label for="exampleInputPassword1" class="form-label">Password</label>
            <input type="password" v-model="user.password" class="form-control" id="exampleInputPassword1">
        </div>
        <button type="submit" @click="register" class="btn btn-primary">Submit</button>
    </div>
</template>

<script>
    export default {
        name: "RegisterForm",
        data : () => ({
            user:{
                name:"",
                email : "",
                password : "",
            }
        }),
        methods : {
            register(){
                this.$store.dispatch('currentUser/registerUser', this.user);
                window.location.replace("/login");
            }
        }

    }
</script>

<style scoped>

</style>
