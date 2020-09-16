<?php

namespace App\Models;

use App\Comment;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * Class User
 * @package App\Models
 */
class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
        'email',
        'password',
        'avatar',
        'ban_status',
        'role'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * @param string $password
     */
    public function setPasswordAttribute(string $password)
    {
        $this->attributes['password'] = bcrypt($password);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function topics()
    {
        return $this->hasMany(Topic::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function favorite_topics()
    {
        return $this->belongsToMany(
            Topic::class,
            'user_topics',
            'user_id',
            'topic_id'
        );
    }

    /**
     * @return string
     */
    public function getAvatarAttribute()
    {
        if ($img = $this->original['avatar']) {
            return asset("storage/uploads/pfp/{$img}");
        }

        return asset('images/noavatar.jpg');
    }

    /**
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'name';
    }

    /**
     *
     */
    public function makeAdmin()
    {
        $this->role = 1;
        $this->save();
    }

    /**
     *
     */
    public function makeStandart()
    {
        $this->role = 0;
        $this->save();
    }

    /**
     * @param $value
     */
    public function toggleAdmin($value)
    {
        if (!$value){
            return $this->makeStandart();
        }

        return $this->makeAdmin();
    }

    /**
     *
     */
    public function ban()
    {
        $this->ban_status = 1;
        $this->save();
    }

    /**
     *
     */
    public function unban()
    {
        $this->ban_status = 0;
        $this->save();
    }

    /**
     * @param $value
     */
    public function toggleBan($value)
    {
        if (!$value){
            return $this->unban();
        }

        return $this->ban();
    }
}
