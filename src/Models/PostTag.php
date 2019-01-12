<?php

namespace H4MSK1\Models;

use Illuminate\Database\Eloquent\Model;

class PostTag extends Model
{
    /**
     * Disable Timestamps
     *
     * @var bool
     */
    public $timestamps = false;
    
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'post_tags';

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

    public function tag()
    {
        return $this->hasOne(Tag::class, 'id', 'tag_id');
    }

    public function post()
    {
        return $this->hasOne(Post::class, 'id', 'post_id');
    }
}
