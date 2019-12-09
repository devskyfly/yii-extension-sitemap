<?php
$db = require __DIR__ . '/db/config.php';
$sitemap = require __DIR__.'/sitemap/config.php';

return [
    'db' => $db,
    'sitemap' => $sitemap,
];
