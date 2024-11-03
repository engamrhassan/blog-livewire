<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    public function scopePublished($query):void
    {
        $query->where('published_at', '<=', Carbon::now());
    }

    public function scopeFeatured($query):void
    {
        $query->where('featured', true);
    }
}
