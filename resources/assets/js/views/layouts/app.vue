<template>
    <section class="section">
        <div class="container">
            <div class="columns">
                <div class="column is-3">
                    <nav class="panel">
                        <p class="panel-heading">
                           Menu
                        </p>
                        <router-link  class="panel-block" :to="{ name: 'my.articles' }" exact>
                            <span class="panel-icon">
                              <i class="fa fa-book"></i>
                            </span>
                            My Articles
                        </router-link>
                        
                        <router-link class="panel-block" :to="{ name: 'articles.create' }" exact>
                            <span class="panel-icon">
                              <i class="fa fa-pencil"></i>
                            </span>
                            Create article
                        </router-link>
                        
                        <router-link  class="panel-block" :to="{ name: 'favorites.index' }">
                            <span class="panel-icon">
                              <i class="fa fa-heart"></i>
                            </span>
                            Favorites                            
                        </router-link>
                        
                        <a class="panel-block" @click="logout">
                            <span class="panel-icon">
                              <i class="fa fa-sign-out"></i>
                            </span>
                            Logout
                        </a>
                    </nav>
                </div>
                <div class="column">
                    <router-view></router-view>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
    export default {
        methods: {
            logout() {
                axios.post('/auth/logout')
                    .then( () => {
                        Laravel.user = null;
                        ev.fire('SuccessfulLogout');
                        this.$router.push('/'); 
                    });
            }
        }
    }
</script>