<?php

namespace App\Models;

use App\Models\User;
use App\Models\Comment;
use App\Models\Category;
use App\Models\PostMedia;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Nicolaslopezj\Searchable\SearchableTrait;

class Page extends Model
{
    use Sluggable, SearchableTrait;

    protected $table = 'posts';

    protected $guarded = [];

    public function sluggable(): array {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }

    protected $searchable = [
        'columns' => [
            'posts.title'       => 10,
            'posts.description' => 10,
        ]
    ];

    public function status() {
        return $this->status == 1 ? 'Active' : 'Inactive';
    }

    public function category() {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function user() {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function media() {
        return $this->hasMany(PostMedia::class, 'post_id', 'id');
    }
}
