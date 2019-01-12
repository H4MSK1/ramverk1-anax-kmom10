<?php

// Load the configuration files
$cfg = $di->get("configuration");
$config = $cfg->load("database");
$connection = $config["config"] ?? [];

preg_match('/host=(.*?)(;port=(.*?))?;dbname=(.*?)$/', $connection['dsn'], $dsn);

$connectionSetup = [
    'driver'    => 'mysql',
    'host'      => $dsn[1],
    'database'  => $dsn[4],
    'username'  => $connection['username'],
    'password'  => $connection['password'],
    'prefix'    => $connection['table_prefix'],
    'charset'   => 'utf8',
    'collation' => 'utf8_unicode_ci',
];

if (is_numeric($dsn[3])) {
    $connectionSetup['port'] = $dsn[3];
}

$capsule = new \Illuminate\Database\Capsule\Manager();
$capsule->addConnection($connectionSetup);
$capsule->setAsGlobal();
$capsule->bootEloquent();

return $capsule;
