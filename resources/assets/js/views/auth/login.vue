<template>
    <div class="hero-body" >
        <div class="container"> 
            <div class="columns is-vcentered">
                <div class="column is-4 is-offset-4">
                    <h1 class="title">
                       Welcome to VueBlog.
                    </h1>
                    <div class="box">
                        <form method="POST" @submit.prevent="login">
                            <div class="notification is-danger" v-if="showErrorMessage">
                                <button class="delete" @click='showErrorMessage = false'></button>
                                These credentials do not match our records.
                            </div>
                            
                            <!-- Input email -->
                            <div class="field">
                                <label class="label">Email</label>
                                <p class="control">
                                    <input type="email" class="input" 
                                        name="email" v-model="form.email" required>
                                </p>
                            </div>

                            <!-- Input password -->
                            <div class="field">
                                <label class="label">Password</label>
                                <p class="control">
                                    <input type="password" class="input" name="password"
                                        v-model="form.password" required>
                                </p>
                            </div>

                            <hr>

                            <!-- Button sign up -->
                            <p class="control">
                                <button type="submit" class="button is-primary" 
                                    :class="isLoading ? 'is-loading' : ''">Sign in</button>
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
                    email: '',
                    password: ''
                }),

                isLoading: false,

                showErrorMessage: false
            }
        },

        methods: {
            login() {
                this.isLoading = true;

                this.form.post('/auth/login')
                    .then(({data}) => {
                        Laravel.user = data;
                        ev.fire('SuccessfulLogin', data);
                        this.$router.push({ path : '/' });
                    }).catch( error => {
                        this.isLoading = false;
                        this.showErrorMessage = true;
                    });
            }
        }
    }
</script>