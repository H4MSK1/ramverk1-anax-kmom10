<?php

namespace H4MSK1\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
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
    protected $table = 'tags';

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

    public function posttag()
    {
        return $this->hasMany(PostTag::class, 'tag_id', 'id');
    }
}
