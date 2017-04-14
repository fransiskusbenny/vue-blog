<template>
    <div class="hero-body" >
        <div class="container"> 
            <div class="columns is-vcentered">
                <div class="column is-4 is-offset-4">
                    <h1 class="title">
                       Welcome to VueBlog.
                    </h1>
                    <div class="box">
                        <!-- form register -->
                         <form method="POST" @submit.prevent="register">
                            <div class="notification is-primary" v-if="registrationSuccess">
                                <button class="delete"></button>
                                Your account successfuly registered.
                            </div>

                            <!-- Input name -->
                            <div class="field">
                                <label class="label">Name</label>
                                <p class="control">
                                    <input type="text" class="input" :class="form.errors.has('name') ? 'is-danger' : ''" 
                                        name="name" v-model="form.name">
                                    <span class="help is-danger" v-if="form.errors.has('name')">
                                        {{ form.errors.get('name') }}        
                                    </span>
                                </p>
                            </div>

                            <!-- Input email -->
                            <div class="field">
                                <label class="label">Email</label>
                                <p class="control">
                                    <input type="email" class="input" :class="form.errors.has('email') ? 'is-danger' : ''" 
                                        name="email" v-model="form.email">

                                    <span class="help is-danger" v-if="form.errors.has('email')">
                                        {{ form.errors.get('email') }}        
                                    </span>
                                </p>
                            </div>
                            <hr>

                            <!-- Input password -->
                            <div class="field">
                                <label class="label">Password</label>
                                <p class="control">
                                    <input type="password" class="input" :class="form.errors.has('password') ? 'is-danger' : ''" 
                                        name="password" v-model="form.password">

                                    <span class="help is-danger" v-if="form.errors.has('password')">
                                        {{ form.errors.get('password') }}        
                                    </span>
                                </p>
                            </div>

                            <!-- Input password confirmation -->
                            <div class="field">
                                <label class="label">Confirm Password</label>
                                <p class="control">
                                    <input type="password" class="input"
                                        name="password_confirmation" v-model="form.password_confirmation">
                                </p>
                            </div>

                            <hr>

                            <!-- Button sign up -->
                            <p class="control">
                                <button class="button is-primary" :class="{ 'is-loading' : isLoading }">
                                    Sign up
                                </button>
                            </p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                form: new Form({
                    name: '',
                    email: '',
                    password: '',
                    password_confirmation: ''
                }),

                registrationSuccess: false,

                isLoading: false
            }
        },

        methods: {
            register() {
                this.isLoading = true

                this.form.post('/auth/register')
                    .then(({data}) => {
                        this.registrationSuccess = true;
                        this.isLoading = false
                    }).catch(error => {
                        this.isLoading = false
                    });
            }
        }
    }
</script>