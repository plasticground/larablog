<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    /**
     * @var string[]
     */
    protected $fillable = [
        'text',
        'user_id',
        'topic_id',
        'status'
    ];
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function topic()
    {
        return $this->belongsTo(Topic::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function author()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     *
     */
    public function allow()
    {
        $this->status = 1;
        $this->save();
    }

    /**
     *
     */
    public function disAllow()
    {
        $this->status = 1;
        $this->save();
    }

    /**
     *
     */
    public function toggleStatus()
    {
        if ($this->status == 0) {
            return $this->allow();
        }

        return $this->disAllow();
    }
}
