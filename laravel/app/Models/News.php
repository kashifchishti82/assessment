<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    protected $fillable = [
        'title',
        'description',
        'content',
        'published_at',
        'source_id',
    ];

    protected function casts(): array
    {
        return [
            'published_at' => 'datetime:Y-m-d',
        ];
    }

    public function authors()
    {
        return $this->belongsToMany(Author::class, 'news_authors');
    }

    public function source()
    {
        return $this->belongsTo(Source::class);
    }

    public function images()
    {
        return $this->morphMany(Images::class, 'imageable');
    }

    public function scopeOrderByPublishedAt($query, $order)
    {
        return $query->orderBy('published_at', $order);
    }

    public function scopeAuthor($query, $author_id)
    {
        return $query->whereHas('authors', function ($query) use ($author_id) {
            $query->where('authors.id', $author_id);
        });
    }

    public function scopeTitle($query, $title){
        return $query->where('title', 'like', "%$title%");
    }
    public function scopeSource($query, $source){
        return $query->where('source_id', $source);
    }
}
