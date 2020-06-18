<?php

require_once __DIR__ . "/../vendor/autoload.php";

/**
 * Atualiza sitemap e feed RSS
 */
(new \Source\Support\Sitemap())->exeSitemap()->exeRSS();