<?php

namespace Anax\View;

/**
 * Style chooser.
 */

// Show incoming variables and view helper functions
//echo showEnvironment(get_defined_vars(), get_defined_functions());



?>
<div class="clearfix">
    <h4 class="title float-left">Users</h4>
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
