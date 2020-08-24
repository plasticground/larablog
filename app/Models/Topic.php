<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'body', 'user_id', 'image', 'description'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function author()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function getImageAttribute()
    {
        if (isset($this->original['image']))
        {
            return asset("storage/uploads/{$this->original['image']}");
        } else {
            return '/images/noimage.jpg';
        }

        return asset('/images/noimage.jpg');
    }
}
