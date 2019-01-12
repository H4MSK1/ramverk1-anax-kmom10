<?php

namespace H4MSK1\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    /**
     * Disable Timestamps
     *
     * @var bool
     */
    public $timestamps = true;
    
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * Primary Key of the Table
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['*'];

    public function post()
    {
        return $this->hasMany(Post::class, 'user_id', 'id');
    }

    public function comment()
    {
        return $this->hasMany(Comment::class, 'user_id', 'id');
    }

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = password_hash($value, PASSWORD_DEFAULT);
    }

    public function verifyPassword($password)
    {
        return password_verify($password, $this->attributes['password']);
    }

    public function setGravatarAttribute($value)
    {
        $this->attributes['gravatar'] = md5(strtolower(trim($value)));
    }

    public function getGravatarImageAttribute()
    {
        return "https://www.gravatar.com/avatar/{$this->attributes['gravatar']}";
    }

    public function getReputationAttribute()
    {
        return $this->attributes['points'] + $this->attributes['votes'];
    }
}
