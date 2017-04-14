<template>
    <div>
        <banner>
            <h1 slot="title" class="title">
               SPA VueBlog with Laravel.
            </h1>
            <h2 slot="subtitle" class="subtitle">
                Lorem ipsum dolor sit amet, consectetur.
            </h2>
        </banner>

        <section class="section">
            <div class="container">
                <div class="columns">
                    <div class="column is-three-quarters">
                    
                        <!-- List of article -->
                        <div class="content" 
                            v-if="articles.data.length > 0"
                            v-for="article in articles.data" 
                        >
                            <single-article :article="article">    
                            </single-article>
                        </div>
                        
                        <div class="content" v-else>
                            <h1 class="title is-3 has-text-centered">
                                No Result :(
                            </h1>
                        </div>

                        <!-- Pagination -->
                        <nav class="pagination" 
                            v-if="articles.data.length > articles.data.per_page"
                        >
                            <a class="pagination-previous" @click="setPage(current_page - 1)" 
                                :disabled="current_page == 1">
                                Previous
                            </a>

                            <a class="pagination-next" @click="setPage(current_page + 1)" 
                                :disabled="articles.current_page == articles.last_page">
                                Next page
                            </a>

                            <ul class="pagination-list">

                                <li v-if="articles.current_page > (1 + offset)">
                                    <a class="pagination-link" @click="setPage(1)">
                                        First
                                    </a>
                                </li>

                                <li v-if="articles.current_page > (1 + offset)">
                                    <span class="pagination-ellipsis">&hellip;</span>
                                </li>

                                <li v-for="pageNumber in totalPages"
                                    @click="setPage(pageNumber)">
                                    <a class="pagination-link" 
                                        :class="{ 'is-current': pageNumber == articles.current_page }">
                                        {{ pageNumber  }}
                                    </a>
                                </li>

                                <li v-if="articles.current_page < (articles.last_page - offset)">
                                    <span class="pagination-ellipsis">&hellip;</span>
                                </li>
                                <li v-if="articles.current_page < (articles.last_page - offset)">
                                    <a class="pagination-link" @click="setPage(articles.last_page)">
                                        Last
                                    </a>
                                </li>
                            </ul>
                        </nav> 
                    </div>
                </div>
            </div>
        </section>    
    </div>
</template>

<script>    
    import SingleArticle from './article'
    
    export default {
        components: {
            SingleArticle
        },
        
        data() {
            return {
                articles: {
                    data: []
                },
                current_page: 1,
                offset: 4
            }
        },

        mounted() {
            this.getArticles(this.current_page)
        },

        computed: {
            totalPages() {
                if (!this.articles.to) {
                    return []
                }

                var from = this.articles.current_page - this.offset;

                if (from < 1) {
                    from = 1;
                }
                var to = from + (this.offset * 2);
                if (to >= this.articles.last_page) {
                    to = this.articles.last_page;
                }

                var pagesArray = [];
                while (from <= to) {
                    pagesArray.push(from);
                    from++;
                }

                return pagesArray;     
            }
        },

        methods: {
            getArticles(page) {
                axios.get('/api/articles', {
                    params: {
                        page: page
                    }
                }).then(({data}) => {
                        this.articles = data
                    })
            },

            setPage(pageNumber) {
                this.current_page = pageNumber;

                if (this.current_page > this.articles.last_page) {
                    this.current_page = this.articles.last_page
                }

                this.getArticles(this.current_page)
            }
        }
    }
</script>
