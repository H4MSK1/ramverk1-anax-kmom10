<?php

namespace Anax\View;

/**
 * Style chooser.
 */

// Show incoming variables and view helper functions
//echo showEnvironment(get_defined_vars(), get_defined_functions());



?><pre>
    <?php foreach ($questions as $post) : ?>
        <?php var_dump($post->user->verifyPassword('lol123')); ?>
    <?php endforeach; ?>
</pre>
