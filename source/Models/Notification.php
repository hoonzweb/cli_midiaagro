<?php

namespace Source\Models;

use CoffeeCode\DataLayer\DataLayer;

/**
 * Class Notification
 * @package Source\Models
 */
class Notification extends DataLayer
{
    /**
     * Notification constructor.
     */
    public function __construct()
    {
        parent::__construct("notifications", ["image", "title", "link"]);
    }
}