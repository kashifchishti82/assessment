<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Images extends Model
{

    protected $fillable = ['url'];

    public function imageable()
    {
        return $this->morphTo();
    }
}
