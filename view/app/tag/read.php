<?php

namespace Anax\View;

/**
 * Style chooser.
 */

// Show incoming variables and view helper functions
//echo showEnvironment(get_defined_vars(), get_defined_functions());



?>
<div class="clearfix">
    <h4 class="title float-left">Questions tagged with (<?= $tag->tag ?>)</h4>
</div>
<div class="row">
<?php foreach ($tag->posttag as $item) : ?>
    <div class="col-md-12" style="margin-bottom: 15px">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title"><a href="<?= url("question/read/{$item->post->id}") ?>"><?= $item->post->title ?></a></h5>
                <span class="card-link">Votes: <?= $item->post->points ?></span>
                <span class="card-link">Answer(s): <?= $item->post->answers->count() ?></span>

                <div class="user-section float-right">
                    <div class="user-info">
                        <img src="<?= $item->post->user->gravatar_image ?>" align="left" />
                        <span>asked <?= $item->post->created_at ?></span>
                        <a href="<?= url("user/profile/{$item->post->user->id}") ?>"><?= $item->post->user->username ?></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>
</div>
