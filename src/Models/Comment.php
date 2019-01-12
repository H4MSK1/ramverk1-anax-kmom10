<?php

namespace H4MSK1\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
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
    protected $table = 'comments';

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
        return $this->belongsTo(Post::class, 'post_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
