<x-layout>
    <h1>Hello World!</h1>
    <article>
    
    <h1>{!!$post->title!!}</h1>

    <p>
        <a href="#">{{ $post->category->name }}</a>
    </p>

    <div>
        {!!$post->body!!}
    </div>

    </article>
    <button><a href="/">Go Back...</a></button>
</x-layout>