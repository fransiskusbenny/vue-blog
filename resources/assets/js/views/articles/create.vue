<template>
    <nav class="panel">
        <p class="panel-heading">
            Create New Article
        </p>
        <div class="panel-block"> 
            <div class="control">
                <div class="notification is-success" v-if="successMessage">
                    <button class="delete" @click="successMessage = false"></button>
                    Your article successfuly published.
                </div>
                <form-article :form="form"></form-article>
            </div>
        </div>
        <div class="panel-block">
            <div class="field">
                <p class="control">
                    <button class="button is-primary" :class="{ 'is-loading' : isLoading }" 
                        @click="publishArticle">Publish</button>
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
                successMessage: false
            }
        },
        
        methods: {
            publishArticle() {
                this.isLoading = true
                this.form.post('/api/articles')
                    .then(({data}) => {
                        this.isLoading = false
                        this.successMessage = true
                    }).catch(error => {
                        this.isLoading = false
                    });
            }
        }
    }
</script>