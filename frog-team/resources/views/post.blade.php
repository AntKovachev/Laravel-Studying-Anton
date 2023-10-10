<x-layout>
    <h1>Hello World!</h1>
    <article>
    
    <h1>{!!$post->title!!}</h1>

    <p>
        By <a href="#">{{$post->user->name}}</a> in <a href="/categories/{{$post->category->slug}}">{{ $post->category->name }}</a>
    </p>

    <div>
        {!!$post->body!!}
    </div>

    </article>
    <button><a href="/">Go Back...</a></button>
</x-layout>