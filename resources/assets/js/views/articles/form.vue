<template>
    <form action="POST">        
        <!-- Select Tags  -->
        <div class="field">
            <label for="content" class="label">Select tags</label>
            <p class="control">
                <multiselect v-model="form.tags" :options="tags" label="name" :max="5" class="is-danger"
                    track-by="name" :hide-selected="true" :close-on-select="false" :multiple="true">        
                </multiselect>
                
                <span class="help is-danger" v-if="form.errors.has('tags')">
                    {{ form.errors.get('tags') }}        
                </span>
            </p>
        </div>

        <!-- Input title -->
        <div class="field">
            <label for="title" class="label">Title of article</label>
            <p class="control">
                <input type="text" class="input" :class="{ 'is-danger' : form.errors.has('title') }" 
                    name="title" v-model="form.title">
                <span class="help is-danger" v-if="form.errors.has('title')">
                    {{ form.errors.get('title') }}        
                </span>
            </p>
        </div>

        <!-- Textarea content -->
        <div class="field">
            <label for="content" class="label">Content</label>
            <p class="control">
                <textarea name="content" id="content" class="textarea" :class="{ 'is-danger' : form.errors.has('content') }"
                    style="max-height: none" return="id"
                    v-model="form.content" :multiple="true"></textarea>
                 <span class="help is-danger" v-if="form.errors.has('content')">
                    {{ form.errors.get('content') }}        
                </span>
            </p>
        </div>
    </form>
</template>

<script>
    import autosize from 'autosize'
    import Multiselect from 'vue-multiselect'
    
    export default {
        components: {
            Multiselect
        },
        
        props: {
            form: {
                required: true
            }
        },
        
        data() {
            return {
                tags: []
            }
        },
        
        mounted() {
            autosize(document.querySelector('textarea'));
            this.getTags()
        },
        
        updated() {
            autosize.update(document.querySelector('textarea'));
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

<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>