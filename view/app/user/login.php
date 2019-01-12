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
        <div class="clearfix">
            <h4 class="title float-left">Login</h4>
            <span class="float-right">Don't have an account? <a href="<?= url('user/register') ?>" class="btn btn-success">Click here</a>
        </div>
        <?= $form ?>
    </div>
</div>
