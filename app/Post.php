<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{

    const PAGINATION_NUMBER = 6;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function tags() {
        return $this->belongsToMany(Tag::class)->using(PostTag::class);
    }

    public function comments() {
        return $this->hasMany(Comment::class);
    }

    public function likes() {
        return $this->hasMany(Like::class);
    }

    public function scopeHasTag(Builder $builder, $tag) {

        return $builder->whereHas('tags', function ($query) use ($tag) {
            $query->where('name', $tag);
        });

    }

}
