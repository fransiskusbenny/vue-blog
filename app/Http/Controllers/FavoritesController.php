<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class FavoritesController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return auth()->user()->favorites;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function favorite(Article $article)
    {
        return auth()->user()->favorites()->toggle($article->id);
    }
    
    /**
     * Determine if the current user is already favorite the article.
     * @param  Article $article [description]
     * @return boolean          [description]
     */
    public function isFavorited(Article $article)
    {
        $isFavorited = auth()->user()
            ->favorites()
            ->where('article_id', $article->id)
            ->exists();
            
        return response()->json($isFavorited); 
    }
}
