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
        <h4 class="title">Answer question (<?= $question->title ?>)</h4>
        <?= $form ?>
    </div>
</div>
