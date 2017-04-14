<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class ArticlesController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']);
    }

    /**
     * Display a listing of the article.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Article::with(['user', 'tags'])
            ->withCount('favorites')
            ->latest()
            ->paginate(15);
    }
    
    /**
     * Store a newly created article in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store()
    {   
        $this->validate(request(), [
            'title' => 'required', 
            'content' => 'required',
            'tags.*.id' => 'exists:tags,id'
        ]);

        $article = auth()->user()->articles()->create(request()->all());
        
        $article->tags()->attach(request('tags.*.id'));
        
        return response()->json([
            'article ' => $article->load('tags')
        ]);
    }

    /**
     * Display the specified article.
     *
     * @param Article $article
     * @return Article
     */
    public function show($id)
    {
        return Article::with(['user', 'tags'])
            ->withCount('favorites')
            ->findOrFail($id);
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Article $article)
    {
        if ($article->user_id == auth()->id()) {
            return $article->load(['user', 'tags']);
        }
        
        abort(401); 
    }

    /**
     * Update the specified article in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Article $article)
    {
        $this->validate(request(), [
            'title' => 'required', 
            'content' => 'required',
            'tags.*.id' => 'exists:tags,id'
        ]);
        
        $article->update(request()->all());
        
        $article->tags()->sync(request('tags.*.id'));
        
        return $article->load('tags');
    }

    /**
     * Remove the specified article from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Article $article)
    {
        $article->delete();
        
        return response()->json([
            'message' => 'Your article successfuly deleted.' 
        ]);
    }
    
    /**
     * Display a listing of current user article.
     *
     * @return \Illuminate\Http\Response
     */
    public function userArticles()
    {
        return Article::with('tags')
            ->where('user_id', auth()->id())
            ->latest()
            ->paginate();
    }
}
