<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{

    const POPULAR_TAG_COUNT = 5;

    protected $fillable = ['name'];

    public function getRouteKeyName()
    {
        return 'name';
    }

    public function posts() {
        return $this->belongsToMany(Post::class)->using(PostTag::class);
    }

    public static function getUniqueTags($tags) {

        // explode tags
        $tags = explode(',', $tags);

        // make sure the elements are unique
        return array_unique(array_map('trim', $tags));

    }

    public static function getTagByName($name) {

        // check if tag already exist
        $record = self::where('name', $name)->first();

        // if not we need to create it
        if (!$record) {
            $record = self::create([
                'name' => $name
            ]);
        }

        return $record;

    }

    public static function getTagsByMostPopular($top = 5) {

        $ordered_tags = PostTag::selectRaw('`tag_id`, COUNT(*) AS total')
            ->groupBy('tag_id')
            ->orderByRaw('COUNT(*) DESC')
            ->get();

        $top_tags = $ordered_tags->take($top)->pluck('tag_id');

        return Tag::find($top_tags);

    }

}
