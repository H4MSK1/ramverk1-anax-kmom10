<?php

namespace Anax\View;

/**
 * A layout rendering views in defined regions.
 */

// Show incoming variables and view helper functions
//echo showEnvironment(get_defined_vars(), get_defined_functions());

$htmlClass = $htmlClass ?? [];
$lang = $lang ?? "sv";
$charset = $charset ?? "utf-8";
$title = ($title ?? "No title") . ($baseTitle ?? " | No base title defined");
$bodyClass = $bodyClass ?? null;

// Set active stylesheet
$request = $di->get("request");
$session = $di->get("session");

// Get current route to make as body class
$route = "route-" . str_replace("/", "-", $di->get("request")->getRoute());

?><!doctype html>
<html <?= classList($htmlClass) ?> lang="<?= $lang ?>">
<head>

    <meta charset="<?= $charset ?>">
    <title><?= $title ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <?php if (isset($stylesheets)) : ?>
        <?php foreach ($stylesheets as $stylesheet) : ?>
            <link rel="stylesheet" type="text/css" href="<?= asset($stylesheet) ?>">
        <?php endforeach; ?>
    <?php endif; ?>

    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">

    <?php if (isset($style)) : ?>
    <style><?= $style ?></style>
    <?php endif; ?>

</head>

<body <?= classList($bodyClass, $route) ?>>

<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container">
        <a class="navbar-brand" href="<?= url('index') ?>">tech overflow</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor02" aria-controls="navbarColor02" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarColor02">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="<?= url('index') ?>">Home</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="<?= url('question/all') ?>">Questions</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="<?= url('tag/all') ?>">Tags</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="<?= url('user/all') ?>">Users</a>
                </li>
            </ul>

            <ul class="navbar-nav">
            <?php if (! $session->has('user') || is_null($session->get('user'))) : ?>
                <li class="nav-item active">
                    <a class="nav-link" href="<?= url('user/login') ?>">Login</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="<?= url('user/register') ?>">Register</a>
                </li>
            <?php else : ?>
                <li class="nav-item active">
                    <a class="nav-link" href="<?= url('question/create') ?>">Ask a Question</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="<?= url('user') ?>">My profile</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="<?= url('user/update') ?>">Settings</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="<?= url('user/logout') ?>">Logout</a>
                </li>
            <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

<main class="section-space">
    <div class="container">
        <?php if (regionHasContent("main")) : ?>
            <?php renderRegion("main") ?>
        <?php endif; ?>
    </div>
</main>

<footer class="footer section-space">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h6>&copy; techoverflow <?= date('Y') ?></h6>
            </div>
        </div>
    </div>
</footer>

<!-- render javascripts -->
<?php if (isset($javascripts)) : ?>
    <?php foreach ($javascripts as $javascript) : ?>
    <script src="<?= asset($javascript) ?>"></script>
    <?php endforeach; ?>
<?php endif; ?>

</body>
</html>
