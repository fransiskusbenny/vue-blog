<template>
    <nav class="panel" >
        <p class="panel-heading">
           Favorites Article
        </p>
        <router-link class="panel-block" 
            v-if="articles.length > 0" 
            v-for="article in articles" 
            :key="article.id"
            :to="{ name: 'articles.show', params: { id: article.id } }"
        >
            {{ article.title }}
        </router-link>
        
        <div class="panel-block" v-if="articles.length == 0">
            No Result :(
        </div>
    </nav>
</template>

<script>
    export default {
        data() {
            return {
                articles: []    
            }
        },
        
        mounted() {
            this.getFavoritesArticle()
        },
        
        methods: {
            getFavoritesArticle() {
                axios.get('/api/favorites')
                    .then(({data}) => {
                        this.articles = data
                    });
            }
        }
    }
</script>