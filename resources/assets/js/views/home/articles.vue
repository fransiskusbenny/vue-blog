<template>
    <div class="columns">
        <div class="column">            
            <!-- List Article -->
            <nav class="panel" v-if="articles.data.length > 0">
                <p class="panel-heading">
                    Articles
                </p>
                <router-link 
                    v-for="article in articles.data" 
                    :key="article.id"
                    :to="{ name: 'articles.edit', params: { id: article.id } }" 
                    class="panel-block">
                    {{ article.title }}
                </router-link>
            </nav>
            
            <nav class="panel" v-else>
                <p class="panel-heading">
                   Articles
                </p>
                <div class="panel-block">
                    No Result :(
                </div>
            </nav>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                articles: {
                    data: []
                },
            }
        },
        
        mounted() {
            this.getArticles();
        },
        
        methods: {
            getArticles() {
                axios.get('/api/user/articles')
                .then(({data}) => {
                   this.articles = data 
                });
            }
        }
    }
</script>