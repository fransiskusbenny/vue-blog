<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>
        <link rel="stylesheet" href="/css/app.css">
        <script>
            window.Laravel = {!! json_encode([
                'csrfToken' => csrf_token(),
                'user' => Auth::user() ?? null
            ]) !!}
        </script>
    </head>
    <body>

        <div id="app">
            <navbar></navbar>
            
            <router-view></router-view>
        </div>

    
    <script src="/js/app.js"></script>
    <script id="dsq-count-scr" src="//vue-blog.disqus.com/count.js" async></script>                    
    </body>
</html>
