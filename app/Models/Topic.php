<?php

namespace App\Models;

use App\Models\Tag;
use App\Models\Category;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

/**
 * Class Topic
 * @property int $id
 * @property int $user_id
 * @property string $title
 * @property string $body
 * @package App\Models
 */
class Topic extends Model
{
    use Sluggable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'body',
        'user_id',
        'image',
        'description',
        'category_id',
        'status',
        'views',
        'is_featured'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function author()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function category()
    {
        return $this->hasOne(Category::class,'id', 'category_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function tags()
    {
        return $this->belongsToMany(
            Tag::class,
            'topics_tags',
            'topic_id',
            'tag_id'
        );
    }

    public function favorite_users()
    {
        return $this->belongsToMany(
          User::class,
          'user_topics',
            'topic_id',
            'user_id'
        );
    }

    /**
     * @return string
     */
    public function getImageAttribute()
    {
        if ($img = $this->original['image']) {
            return asset("storage/uploads/{$img}");
        }

        return asset('images/noimage.jpg');
    }

    /**
     * @return \string[][]
     */
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }

    /**
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * Save topic as draft
     */
    public function setDraft()
    {
        $this->status = 0;
        $this->save();
    }

    /**
     * Save topic as public (no draft)
     */
    public function setPublic()
    {
        $this->status = 1;
        $this->save();
    }

    /**
     * @param $value
     * Toggle Draft/Draft
     */
    public function toggleStatus($value)
    {
        if(!$value) {
            return $this->setDraft();
        }

        return  $this->setPublic();
    }

    /**
     * Save topic as featured
     */
    public function setFeatured()
    {
        $this->is_featured = 1;
        $this->save();
    }

    /**
     * Save topic as standard (no featured)
     */
    public function setStandard()
    {
        $this->is_featured = 0;
        $this->save();
    }

    /**
     * @param $value
     * Toggle Standard/Featured
     */
    public function toggleFeatured($value)
    {
        if (!$value) {
            return $this->setStandard();
        }

        return $this->setFeatured();
    }

    /**
     * @param Category $category
     */
    public function setCategory($category)
    {
        if ($category == null) {
            $this->category_id = Category::firstOrCreate(['title' => 'Без категории'])->id;
            $this->save();
            return;
        }

        $this->category_id = $category->id;
        $this->save();
    }

    /**
     * @param $ids
     */
    public function setTags($ids)
    {
        if ($ids == null) { return; }

        $this->tags()->sync($ids);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function visit()
    {
        ++$this->views;
        $this->save();
    }
}
