<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Blog;

class Category extends Model
{
    use HasFactory;
    protected $table = 'categories';
    public function blogs(){
        return $this->belongsToMany(Blog::class, BlogCategory::class);
    }
}
