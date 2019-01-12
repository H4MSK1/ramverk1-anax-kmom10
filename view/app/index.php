<?php

namespace Anax\View;

/**
 * Style chooser.
 */

// Show incoming variables and view helper functions
//echo showEnvironment(get_defined_vars(), get_defined_functions());



?>
<div class="clearfix">
    <h4 class="title float-left">Latest questions</h4>
    <a href="<?= url('question/create') ?>" class="btn btn-primary float-right">Ask Question</a>
</div>
<div class="row">
<?php foreach ($questions as $item) : ?>
    <div class="col-md-12" style="margin-bottom: 15px">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title"><a href="<?= url("question/read/{$item->id}") ?>"><?= $item->title ?></a></h5>
                <p>
                    <?php foreach ($item->tag as $tag) : ?>
                        <a class="tag" href="<?= url("tag/read/{$tag->tag->id}") ?>"><?= $tag->tag->tag ?></a>
                    <?php endforeach; ?>
                </p>
                <span class="card-link">Votes: <?= $item->points ?></span>
                <span class="card-link">Answer(s): <?= $item->answers->count() ?></span>
                <span class="card-link">
                    Solved:
                    <?php if ($item->getAcceptedAnswerId() > 0) : ?>
                        <i class="fa fa-check" style="color: green"></i>
                    <?php else : ?>
                        <i class="fa fa-times" style="color: red"></i>
                    <?php endif; ?>
                </span>

                <div class="user-section float-right">
                    <div class="user-info">
                        <img src="<?= $item->user->gravatar_image ?>" align="left" />
                        <span>asked <?= $item->created_at ?></span>
                        <a href="<?= url("user/profile/{$item->user->id}") ?>"><?= $item->user->username ?></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>
</div>

<div class="clearfix">
    <h4 class="title float-left">Active users</h4>
</div>
<div class="row">
<?php foreach ($users as $item) : ?>
    <div class="col-md-4" style="margin-bottom: 15px">
        <div class="card">
            <div class="card-body text-center">
                <a href="<?= url("user/profile/{$item->id}") ?>">
                    <h6 class="card-title"><?= $item->username ?></h6>
                    <p><img src="<?= $item->gravatar_image ?>" class="gravatar" /></p>
                </a>
            </div>
        </div>
    </div>
<?php endforeach; ?>
</div>

<div class="clearfix">
    <h4 class="title float-left">Popular tags</h4>
</div>
<div class="row">
    <div class="col-md-12" style="margin-bottom: 15px">
        <div class="card">
            <div class="card-body">
                <p>
                    <?php foreach ($tags as $tag) : ?>
                        <a class="tag" href="<?= url("tag/read/{$tag->id}") ?>"><?= $tag->tag ?></a>
                    <?php endforeach; ?>
                </p>
            </div>
        </div>
    </div>
</div>
