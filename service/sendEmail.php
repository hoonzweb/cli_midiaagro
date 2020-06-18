<?php

require_once __DIR__ . "/../vendor/autoload.php";

/**
 * Dispara e-mails da fila
 */
(new \Source\Support\Email())->sendQueue();