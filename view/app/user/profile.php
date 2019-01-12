<?php

namespace Anax\View;

/**
 * Style chooser.
 */

// Show incoming variables and view helper functions
//echo showEnvironment(get_defined_vars(), get_defined_functions());



?>

<div class="row">
    <div class="col-md-12">
        <h4 class="title"><?= $user->username ?>'s profile page</h4>
        <img src="<?= $user->gravatar_image ?>" class="gravatar" align="left" />

        <div class="user-section float-right">
            <div class="user-info text-center" style="font-weight: 600">
                <span>Reputation: <?= $user->reputation ?> | Votes: <?= $user->votes ?></span>
            </div>
        </div>
    </div>
    <div class="col-md-6 offset-md-6">
        <h4 class="title">About <?= $user->username ?></h4>
        <div class="card">
            <div class="card-body">
                <?= textToMarkdown($user->about) ?>
            </div>
        </div>
    </div>
</div>

<hr>

<div class="row">

    <div class="col-md-4" style="margin-bottom: 15px">
        <h4 class="title">Questions (<?= $user->post()->isQuestionOnly()->count() ?>)</h4>
        <?php foreach ($user->post()->isQuestionOnly()->latest()->get() as $item) : ?>
        <div class="card" style="margin-bottom: 15px;<?= ($item->getAcceptedAnswerId() > 0 ? 'border:2px solid green' : '') ?>">
            <div class="card-body">
                <p>
                    <a href="<?= url("question/read/{$item->id}") ?>">
                        <span class="card-title"><?= $item->title ?></span>
                    </a>
                </p>
                <span class="card-link">Answer(s): <?= $item->answers->count() ?></span>
                <span class="card-link">Comments(s): <?= $item->comment->count() ?></span>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

    <div class="col-md-4" style="margin-bottom: 15px">
        <h4 class="title">Answers (<?= $user->post()->isAnswerOnly()->count() ?>)</h4>
        <?php foreach ($user->post()->isAnswerOnly()->latest()->get() as $item) : ?>
        <div class="card" style="margin-bottom: 15px">
            <div class="card-body">
                <a href="<?= url("question/read/{$item->answer_for_post}") ?>">
                    <span class="card-title"><?= mb_strimwidth(strip_tags($item->body), 0, 50) ?></span>
                </a>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

    <div class="col-md-4" style="margin-bottom: 15px">
        <h4 class="title">Comments (<?= $user->comment()->count() ?>)</h4>
        <?php foreach ($user->comment()->latest()->get() as $item) : ?>
        <div class="card" style="margin-bottom: 15px">
            <div class="card-body">
                <a href="<?= url("question/read/{$item->post->getQuestionId()}") ?>">
                    <span class="card-title"><?= truncate(strip_tags($item->body), 25) ?></span>
                </a>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

</div>
