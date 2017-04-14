<template>
    <div>
        <banner>
            <h1 class="title" slot="title">
                {{ article.title }}
            </h1>
        </banner>

        <section class="section">
            <div class="container">
                <div class="columns">
                    <!-- Article-->
                    <div class="column is-three-quarters">
                        <div class="content is-medium">
                            <nav class="level">
                                <div class="level-left">
                                    <div class="level-item">
                                        <p class="subtitle is-5">
                                            Posted by 
                                            <router-link to="">
                                                {{ article.user.name }}    
                                            </router-link>
                                        </p>                                        
                                    </div>
                                    <div class="level-item">
                                        <p class="subtitle is-5">
                                           | {{ article.created_at | ago }}.
                                        </p>                                        
                                    </div>
                                </div>
                            </nav>
                            <p class="article-content" v-html="markdown(article.content)"></p>
                        </div>   
                    </div>
                </div>
           
                <div class="columns" v-if="article.tags.length > 0">
                    <!-- Tags -->
                    <div class="column">
                        <nav class="level">
                            <div class="level-left">
                                <div class="level-item">
                                    <span class="icon" style="opacity: .5"><i class="fa fa-tags"></i></span>
                                </div>
                                <span class="level-item" v-for="tag in article.tags">
                                    <router-link :to="{ name: 'tags.show', params: { slug: tag.slug } }">
                                        #{{ tag.name }}
                                    </router-link>
                                </span>
                            </div>
                        </nav>
                        
                        <nav class="level">
                            <div class="level-left">
                                <div class="level-item">
                                    {{ article.favorites_count }}
                                    <a @click="favorite">
                                        <span class="icon">
                                            <i class="fa fa-heart-o" 
                                                :class="{ 'favorite' : isFavorited}"
                                            >    
                                            </i>
                                        </span>
                                    </a>
                                </div>
                            </div>
                        </nav>
                    </div>
                </div>
                <hr>
                
                <!-- Disqus -->
                <Disqus 
                    :identifier="this.$route.path" 
                    :url="this.$route.path">
                </Disqus>
            </div>
        </section>  
    </div>  
</template>

<script type="text/babel">
    import moment from 'moment'
    import marked from 'marked'

    // Components
    import Disqus from '../../components/Disqus'
    
    export default {

        components: {
            Disqus
        },

        data() {
            return {
                article: {
                    user: {},
                    tags: []
                },
                
                isFavorited: false,
                
                favorites_count: 0
            }
        },

        computed: {
            isLogin() {
                return ! _.isNull(Laravel.user)
            },
        },

        mounted() {
            this.showArticle();
        },

        filters: {
            ago(date) {
                return moment(date).fromNow();
            },
        },

        methods: {
            showArticle() {
                axios.get('/api/articles/' + this.$route.params.id)
                    .then(({data}) => {
                        this.article = data
                    }).then( () => {
                        if (Laravel.user ) {
                            this.isFavorite();
                        }
                    });
            },
            
            favorite() {
                axios.post('/api/favorites/' + this.$route.params.id)
                    .then(({data}) => {
                        if (data.attached.length > 0) {
                            this.article.favorites_count += 1;
                            this.isFavorited = true;
                        } else {
                            this.article.favorites_count -= 1;
                            this.isFavorited = false;
                        }
                    });
            },
            
            isFavorite()  {
                axios.get('/api/is_favorite/' + this.$route.params.id)
                    .then(({data}) => {
                        this.isFavorited = data 
                    });
            },
            
            markdown(text) {
                return marked(text || '');
            }
        }
    }
</script>