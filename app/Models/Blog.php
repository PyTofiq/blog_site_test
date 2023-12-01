<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category;
use App\Models\Author;

class Blog extends Model
{
    use HasFactory;

//    protected $table = 'blogs';
    protected $fillable = [
        'title',
        'description',
        'image',
        'author_id',
    ];

//    protected $guarded = [];

    public function categories()
    {
        return $this->belongsToMany(Category::class, BlogCategory::class);
    }

    public function authors()
    {
        return $this->belongsTo(Author::class, 'author_id');
    }

    public function coverImage()
    {
        if (!is_null($this->image)) {
            return asset($this->image);
        }
        return asset('storage/uploads/default.png');
    }


}
