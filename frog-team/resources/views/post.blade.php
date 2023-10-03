<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Blog</title>
    <link rel="stylesheet" href="/app.css">
</head>
<body>
    <h1>Hello World!</h1>
    <article>
        
       <h1>{{$post->title}}</h1>

       <div>
            {!!$post->body;!!}
       </div>

    </article>
    <button><a href="/">Go Back...</a></button>
</body>
</html>
