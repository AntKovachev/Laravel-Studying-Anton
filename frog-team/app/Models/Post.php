<?php
namespace App\Models;

use Illuminate\Support\Facades\File;
use Spatie\YamlFrontMatter\YamlFrontMatter;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class Post
{
    public $title;
    public $excerpt;
    public $date;
    public $body;
    public $slug;

    public function __construct($title, $excerpt, $date, $body, $slug)
    {
        $this->title = $title;
        $this->excerpt = $excerpt;
        $this->date = $date;
        $this->body = $body;
        $this->slug = $slug;
    }

    public static function all ()
    {
        return cache()->rememberForever('posts.all', function() {
             //Find all the files in the posts directory and collect them in collection
            return collect(File::files(resource_path("posts")))

            //Map over each item (loop), and for each file parse that file into a document 
            ->map(fn($file) => YamlFrontMatter::parseFile($file))

            //Once we have collection of documents, map over it again and build a document object that we're in control of
            ->map(fn($document) => new Post(
                    $document->title,
                    $document->excerpt,
                    $document->date,
                    $document->body(),
                    $document->slug
            ))
            ->sortByDesc('date');
        });
    }
                            //Requested slug
    public static function find ($slug) 
    {
        //of all the blog posts, find the one with the slug that matches the one that was requested.

        return static::all()->firstWhere('slug', $slug);
    }
}