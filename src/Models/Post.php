<?php

namespace H4MSK1\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
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
    protected $table = 'posts';

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

    public function store($form, $userId, $isQuestion)
    {
        $this->user_id = $userId;
        $this->title = $form->value('title');
        $this->body = $isQuestion ? $form->value('body') : $form->value('answer');

        if ($isQuestion) {
            $this->is_question = '1';
        } else if (! empty($form->value('answer_for_post'))) {
            $this->answer_for_post = $form->value('answer_for_post');
        }

        $this->save();

        $postId = $this->id;

        if ($isQuestion && ! empty($form->value('tags'))) {
            foreach (explode(' ', $form->value('tags')) as $value) {
                $tag = Tag::where('tag', $value)->first();

                if ($tag == null) {
                    $tag = new Tag();
                    $tag->tag = trim($value);
                    $tag->body = 'No description yet.';
                    $tag->save();
                }

                $postTag = new PostTag();
                $postTag->tag_id = $tag->id;
                $postTag->post_id = $postId;
                $postTag->save();
            }
        }

        $user = User::find($userId);
        $user->points = $user->points + 2;
        $user->save();
    }

    public function comment()
    {
        return $this->hasMany(Comment::class, 'post_id', 'id');
    }

    public function tag()
    {
        return $this->hasMany(PostTag::class, 'post_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function scopeIsQuestionOnly($query)
    {
        return $query->where('is_question', '1');
    }

    public function scopeIsAnswerOnly($query)
    {
        return $query->where('is_question', '0');
    }

    public function scopeGetQuestionId($query)
    {
        return $this->isPostQuestion() ? $this->attributes['id'] : $this->attributes['answer_for_post'];
    }

    public function getBodyAttribute()
    {
        $filter = new \Anax\TextFilter\TextFilter();
        return html_entity_decode($filter->parse($this->attributes['body'], ["markdown"])->text);
    }

    public function getCreatedAtAttribute()
    {
        $value = (new \Carbon\Carbon($this->attributes['created_at']))->format("M d'y");
        $value .= " at " . (new \Carbon\Carbon($this->attributes['created_at']))->format("H:i");
        return $value;
    }

    public function getAnswersAttribute()
    {
        return Post::where('answer_for_post', $this->id)->get();
    }

    public function getAnswersSortedBy($column = null)
    {
        if (! empty($column)) {
            return Post::where('answer_for_post', $this->id)->orderBy($column, 'desc')->get();
        }

        return $this->getAnswersAttribute();
    }

    public function getAcceptedAnswer()
    {
        $answer = $this->attributes['accepted_answer'];

        if ($answer === 0) {
            return null;
        }

        return Post::find($answer);
    }

    public function getAcceptedAnswerId()
    {
        $answer = $this->getAcceptedAnswer();

        return $answer ? $answer->id : 0;
    }

    public function hasAcceptedAnswer()
    {
        return $this->getAcceptedAnswer() !== null;
    }

    public function isPostQuestion()
    {
        return $this->attributes['is_question'] == 1;
    }

    public function isPostAnswer()
    {
        return ! $this->isPostQuestion();
    }
}
