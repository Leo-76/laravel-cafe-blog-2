<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PostController extends Controller
{
    /**
     * Display a paginated list of published posts.
     */
    public function index(Request $request): View
    {
        $query = Post::with(['author', 'category', 'tags'])
            ->published()
            ->latest('published_at');

        if ($search = $request->input('search')) {
            $query->search($search);
        }

        if ($categorySlug = $request->input('category')) {
            $query->whereHas('category', fn ($q) => $q->where('slug', $categorySlug));
        }

        if ($tagSlug = $request->input('tag')) {
            $query->whereHas('tags', fn ($q) => $q->where('slug', $tagSlug));
        }

        $posts      = $query->paginate(9)->withQueryString();
        $categories = Category::withCount(['posts' => fn ($q) => $q->published()])->get();
        $tags       = Tag::withCount('posts')->having('posts_count', '>', 0)->get();
        $featured   = Post::with(['author', 'category'])->published()->latest('published_at')->first();

        return view('posts.index', compact('posts', 'categories', 'tags', 'featured', 'search'));
    }

    /**
     * Display a single post.
     */
    public function show(string $slug): View
    {
        $post = Post::with(['author', 'category', 'tags', 'approvedComments.author'])
            ->published()
            ->where('slug', $slug)
            ->firstOrFail();

        $related = Post::with(['author', 'category'])
            ->published()
            ->where('category_id', $post->category_id)
            ->where('id', '!=', $post->id)
            ->latest('published_at')
            ->limit(3)
            ->get();

        return view('posts.show', compact('post', 'related'));
    }
}
