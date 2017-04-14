<template>

    <nav class="panel">
        <p class="panel-heading">
            Edit Article
        </p>
        <div class="panel-block"> 
            <div class="control">
                <div class="notification is-success" v-if="successMessage">
                    <button class="delete" @click="successMessage = false"></button>
                    Your article successfuly updated.
                </div>
                <form-article :form="form"></form-article>
            </div>
        </div>
        <div class="panel-block">
            <div class="field is-grouped">
                <p class="control">
                    <button 
                        class="button is-info" 
                        :class="{ 'is-loading' : isLoading }"
                        @click="update"
                        >
                            Update
                        </button>
                </p>
                <p class="control">
                    <button class="button is-danger" @click="destroy"> Delete </button>
                </p>
            </div>
        </div>
    </nav> 
</template>

<script>    
    import FormArticle from './form'
    
    export default {
        components: {
            FormArticle
        },
        
        data() {
            return {
                form: new Form({
                    title: '',
                    content: '',
                    tags: []
                }),
                isLoading: false,
                successMessage: false,
                url: '/api/articles/' + this.$route.params.id
            }
        },
        
        mounted() {
            this.getArticleToEdit();
        },
        
        methods: {            
            getArticleToEdit() {
                axios.get(this.url + '/edit')
                    .then(({data}) => {
                        this.form.title = data.title;
                        this.form.content = data.content;
                        this.form.tags = data.tags   
                    });
            },
            
            update() {
                this.isLoading = true
                this.form.patch(this.url)
                    .then(({data}) => {
                        this.isLoading = false;
                        this.successMessage = true;
                        
                        this.form.title = data.title;
                        this.form.content = data.content;
                        this.form.tags = data.tags
                    }).catch(error => {
                        this.isLoading = false
                    });
            },
            
            destroy() {
                this.form.delete(this.url)
                    .then( ()=> {
                        this.$router.push('/articles')
                    });
            }
        }
    }
</script>