<template>
    <div id="disqus_thread"></div>
</template>

<script>
    
    export default {
        props: {
            url: {
                required: true,
                type: String
            }, 
            identifier: {
                required: true,
                type: String
            }
        },
                        
        created() {
            var disqus_config = () =>  {
                this.page.url = this.url; 
                this.page.identifier = this.identifier;
            };
            
            (() =>  { 
                var d = document, s = d.createElement('script');
                s.src = 'https://vue-blog.disqus.com/embed.js';
                s.setAttribute('data-timestamp', +new Date());
                (d.head || d.body).appendChild(s);
            })();         
        }
    }
</script>