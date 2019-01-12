<?php

namespace Anax\View;

/**
 * Style chooser.
 */

// Show incoming variables and view helper functions
//echo showEnvironment(get_defined_vars(), get_defined_functions());

$isAuth = $di->get('session')->get('user') !== null;
$questionBelongsToUser = $isAuth && $di->get('session')->get('user') === $question->user_id;

?>
<div class="clearfix">
    <h4 class="title float-left"><?= $question->title ?></h4>
    <?php if ($isAuth) : ?>
        <a href="<?= url("question/answer/{$question->id}") ?>" class="btn btn-success float-right">Answer Question</a>
    <?php endif; ?>
</div>
<div class="row">
    <div class="col-md-12" style="margin-bottom: 15px">
        <div class="card">
            <div class="card-body">
                <?= $question->body ?>
                <hr>
                <p>
                    <?php foreach ($question->tag as $tag) : ?>
                        <a class="tag" href="<?= url("tag/read/{$tag->tag->id}") ?>"><?= $tag->tag->tag ?></a>
                    <?php endforeach; ?>
                </p>
                <hr>
                <span class="card-link">
                    <div class="vote-section">
                        <span><a href="<?= url("vote/post/{$question->id}/1") ?>"><i class="fa fa-chevron-up"></i></a></span>
                        <span class="points"><?= $question->points ?></span>
                        <span><a href="<?= url("vote/post/{$question->id}/0") ?>"><i class="fa fa-chevron-down"></i></a></span>
                    </div>
                </span>
                <span class="card-link">Answer(s): <?= $question->answers->count() ?></span>
                <span class="card-link">Comments(s): <?= $question->comment->count() ?></span>

                <div class="user-section float-right">
                    <div class="user-info">
                        <img src="<?= $question->user->gravatar_image ?>" align="left" />
                        <span>asked <?= $question->created_at ?></span>
                        <a href="<?= url("user/profile/{$question->user->id}") ?>"><?= $question->user->username ?></a>
                    </div>
                </div>

                <div class="card" style="width: 100%">
                    <div class="card-body">
                        <?php if ($isAuth) : ?>
                            <p class="text-right">
                                <a href="<?= url("question/comment/{$question->id}") ?>" class="btn btn-primary" style="width: 100px">Comment</a>
                            </p>
                            <hr>
                        <?php endif; ?>
                        <?php if ($question->comment->count() > 0) : ?>
                            <?php foreach ($question->comment as $comment) : ?>
                                <div class="vote-section">
                                    <span><a href="<?= url("vote/comment/{$comment->id}/1") ?>"><i class="fa fa-chevron-up"></i></a></span>
                                    <span class="points"><?= $comment->points ?></span>
                                    <span><a href="<?= url("vote/comment/{$comment->id}/0") ?>"><i class="fa fa-chevron-down"></i></a></span>
                                </div>
                                <?= $comment->body ?> – <a href="<?= url("user/profile/{$comment->user->id}") ?>"><?= $comment->user->username ?></a> <?= $comment->created_at->diffForHumans() ?>
                                <hr>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <i>No comments</i>
                        <?php endif; ?>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12" style="margin-bottom: 15px">
        <?php if ($question->answers->count() === 0) : ?>
            <div class="card">
                <div class="card-body">
                    <b>There are no answers for this question yet.</b>
                </div>
            </div>
        <?php else : ?>
            <div class="clearfix">
                <h5 class="float-left"><?= $question->answers->count() ?> Answer(s)</h5>
                <span class="float-right">
                    <a href="<?= url("question/read/{$question->id}?sort=created_at") ?>" class="btn btn-secondary btn-sm">Sort answers by date</a>
                    <a href="<?= url("question/read/{$question->id}?sort=points") ?>" class="btn btn-secondary btn-sm">Sort answers by votes</a>
                </span>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php if ($question->answers->count() > 0) : ?>
    <?php foreach ($question->getAnswersSortedBy($di->get('request')->getGet('sort')) as $answer) : ?>
        <div class="row">
            <div class="col-md-12" style="margin-bottom: 15px">
                <div class="card" <?= ($question->getAcceptedAnswerId() == $answer->id ? 'style="border:2px solid green"' : '') ?>>
                    <div class="card-body">
                        <?= $answer->body ?>
                        <hr>
                        <span class="card-link">
                            <div class="vote-section">
                                <span><a href="<?= url("vote/post/{$answer->id}/1") ?>"><i class="fa fa-chevron-up"></i></a></span>
                                <span class="points"><?= $answer->points ?></span>
                                <span><a href="<?= url("vote/post/{$answer->id}/0") ?>"><i class="fa fa-chevron-down"></i></a></span>
                            </div>
                        </span>
                        <span class="card-link">Comments(s): <?= $answer->comment->count() ?></span>
                        <?php if ($questionBelongsToUser && ! $question->hasAcceptedAnswer()) : ?>
                        <span class="card-link">
                            <a href="<?= url("question/accept/{$question->id}/{$answer->id}") ?>" class="btn btn-success btn-sm">Mark as accepted answer</a>
                        </span>
                        <?php endif; ?>

                        <div class="user-section float-right">
                            <div class="user-info">
                                <img src="<?= $answer->user->gravatar_image ?>" align="left" />
                                <span>answered <?= $answer->created_at ?></span>
                                <a href="<?= url("user/profile/{$answer->user->id}") ?>"><?= $answer->user->username ?></a>
                            </div>
                        </div>

                        <div class="card" style="width: 100%">
                            <div class="card-body">
                                <?php if ($isAuth) : ?>
                                    <p class="text-right">
                                        <a href="<?= url("question/comment/{$answer->id}") ?>" class="btn btn-primary" style="width: 100px">Comment</a>
                                    </p>
                                    <hr>
                                <?php endif; ?>
                                <?php if ($answer->comment->count() > 0) : ?>
                                    <?php foreach ($answer->comment as $comment) : ?>
                                        <?= $comment->body ?> – <a href="<?= url("user/profile/{$comment->user->id}") ?>"><?= $comment->user->username ?></a> <?= $comment->created_at->diffForHumans() ?>
                                        <hr>
                                    <?php endforeach; ?>
                                <?php else : ?>
                                    <i>No comments</i>
                                <?php endif; ?>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    <?php endforeach;?>
<?php endif; ?>
