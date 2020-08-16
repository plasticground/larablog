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
        'title', 'body', 'user_id',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function author()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
