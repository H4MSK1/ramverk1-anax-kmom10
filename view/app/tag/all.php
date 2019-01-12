<?php

namespace Anax\View;

/**
 * Style chooser.
 */

// Show incoming variables and view helper functions
//echo showEnvironment(get_defined_vars(), get_defined_functions());



?>
<div class="clearfix">
    <h4 class="title float-left">Tags</h4>
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
