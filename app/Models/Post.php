<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Post extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'published_at' => 'datetime',
    ];

    public function scopePublished($query):void
    {
        $query->where('published_at', '<=', Carbon::now());
    }

    public function scopeFeatured($query):void
    {
        $query->where('featured', true);
    }

    public function author():belongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getExcerpt():string
    {
        return Str::limit(strip_tags($this->body),150);
    }

    public function getReadingTime():float
    {
        $mins =  round(str_word_count($this->body) / 250);

        return $mins < 1 ? 1 : $mins;
    }
}
