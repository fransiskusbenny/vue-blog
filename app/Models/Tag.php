<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $guarded = [];
    
    public $timestamps = false;
    
    public function getRouteKeyName()
    {
        return 'slug';
    }
        
    public function articles()
    {
        return $this->belongsToMany(Article::class);
    }
}