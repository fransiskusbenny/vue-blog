<template>
    <nav class="nav has-shadow">
        <div class="container">

            <!-- Left menu -->  
            <div class="nav-left">
                <router-link class="nav-item" :to="{ name: 'welcome' }" exact>
                    <i class="fa fa-snowflake-o fa-spin"></i> &nbsp; VueBlog
                </router-link>
                 <router-link class="nav-item" to="/tags">
                    &nbsp; All Tag
                </router-link>
            </div>

            <!-- Right Menu --> 
            <div class="nav-right" v-if="isLogin">
                <router-link class="nav-item is-tab" :to="{ name: 'my.articles' }">
                    <i class="fa fa-home"></i> &nbsp; {{ user.name }}
                </router-link>
            </div>

            <div class="nav-right" v-else>
                <span class="nav-item is-paddingless">
                    <router-link to="/auth/login" class="button">
                        <span class="icon">
                            <i class="fa fa-sign-in"></i>
                        </span>
                        <span>Sign in</span>
                    </router-link>
                     <router-link to="/auth/register" class="button is-primary">
                        <span class="icon">
                            <i class="fa fa-user-plus"></i>
                        </span>
                        <span>Sign up</span>
                    </router-link>
                </span>
            </div>

        </div>
    </nav>
</template>

<script>
    export default {

        data() {
            return {
                user: Laravel.user
            }
        },

        created() {
            ev.listen('SuccessfulLogin', (user) => {
                this.user = user;
            });
            
            ev.listen('SuccessfulLogout', () => {
                this.user = null;
            });
        },

        computed: {
            isLogin() {
                if (! this.user) {
                    return false;
                }

                return true;
            }
        },
    }
</script>