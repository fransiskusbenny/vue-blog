<template>
    <section class="section">
        <div class="container">
            <div class="columns">
                <div class="column">
                    <h1 class="title is-1 has-text-centered">Tags Index</h1>
                    
                    <ul class="has-text-centered"  v-for="(tagCollection, letter) in tagLists">
                        <div class="title is-3" style="margin-top: 2rem; margin-bottom: 1rem">{{ letter | upperCase }}</div>
                        <ul>
                            <li v-for="tag in tagCollection">
                                <router-link :to="{ name: 'tags.show', params: { slug: tag.slug } }">
                                    #{{ tag.name }}
                                </router-link>
                            </li>
                        </ul>
                    </ul>
                </div>
            </div>
        </div>
    </section>
</template>

<script>    
    export default {
        data() {
            return {
                tags: []
            }
        },
        
        computed: {
            tagLists() {
              return _.groupBy(this.tags, function(tag) {
                    return tag.name.substring(0, 1)
                });
            }
        },
        
        filters: {
            upperCase(string) {
                return _.upperCase(string)
            }  
        },
        
        mounted() {
            this.getTags();
        },
        
        methods: {
            getTags() {
                axios.get('/api/tags')
                    .then(({data}) => {
                        this.tags = data
                    });
            }
        }
    }
</script>