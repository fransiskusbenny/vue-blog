<template>
    <div>
        <h1>
            <router-link :to="{ name: 'articles.show', params: { id: article.id } }">
                {{ article.title }}
            </router-link>
        </h1>
        <nav class="level">
            <div class="level-left">
                <span class="level-item">
                    <p class="subtitle is-5">
                        Posted by  <router-link to="">{{ article.user.name }}</router-link>
                    </p>                                        
                </span>
                <span class="level-item">
                    <p class="subtitle is-5">
                        | {{ article.created_at | ago }}.
                    </p>                                        
                </span>
            </div>
        </nav>
        <p v-html="markdown(article.content)"></p>
        <nav class="level" v-if="article.tags.length > 0">
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
                    <span class="disqus-comment-count" 
                        :data-disqus-url="disqusUrl + article.id">    
                    </span>
                    <span class="icon"><i class="fa fa-comment-o"></i></span>
                </div>
                <div class="level-item">
                    {{ article.favorites_count }}
                    <a @click="favorite(article)">
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
        <hr>
    </div>
</template>

<script>
    import moment from 'moment'
    import marked from 'marked'
    
    export default {
        
        props: {
            article: {
                required: true,
                type: Object,
            }
        },
        
        data() {
            return {
                disqusUrl: `http://${window.location.hostname}/articles/`,
                isFavorited: false   
            }
        },
        
        filters: {
            ago(date) {
                return moment(date).fromNow(); 
            }
        },
        
        mounted() {
            if (Laravel.user) {
                this.isFavorite();
            }
        },
        
        methods: {
            markdown(text) {
                return _.truncate(marked(text || ''), {
                    'length': 175,
                });
            },
            
            favorite(article) {
                axios.post('/api/favorites/' + article.id)
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
                axios.get('/api/is_favorite/' + this.article.id)
                    .then(({data}) => {
                        this.isFavorited = data 
                    });
            }
        }
    }
</script>

<style>
    .favorite {
        color: red;
    }
</style>