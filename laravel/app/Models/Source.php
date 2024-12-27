<?php

namespace App\Models;

use App\News\Resolvers\NewsChannels;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
class Source extends Model
{
    protected $fillable = ['name'];

    public function news()
    {
        return $this->hasMany(News::class);
    }

    protected function name(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => NewsChannels::fromName($value)->toString()
        );
    }
}
