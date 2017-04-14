<template>
    <div>
        <banner>
            <h1 slot="title" class="title">
               Tags {{ tag_slug }}
            </h1>
        </banner>
        
        <section class="section">
            <div class="container">
                <div class="columns">
                    <div class="column">
                    
                        <div class="content" 
                            v-if="articles.data.length > 0"
                            v-for="article in articles.data"
                        >
                            <single-article :article="article"></single-article>
                        </div>
                        
                        <div class="content" v-else>
                            <h1 class="title is-3 has-text-centered">
                                No Result :(
                            </h1>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        
    </div>
</template>

<script>
    import SingleArticle from '../articles/article'
    
    export default {
        components: {
            SingleArticle
        },
        
        data() {
            return {
                tag_slug: this.$route.params.slug, 
                articles: []
            }
        },
        
        mounted() {
            this.getArticleWithTag();  
        },
        
        methods: {
            getArticleWithTag() {
                axios.get('/api/tags/' + this.tag_slug)
                    .then(({data}) => {
                        this.articles = data
                    })
            }
        }
    }
</script>