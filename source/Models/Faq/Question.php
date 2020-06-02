<?php

namespace Source\Models\Faq;

use CoffeeCode\DataLayer\DataLayer;

/**
 * Class Question
 * @package Source\Models\Faq
 */
class Question extends DataLayer
{
    /**
     * Question constructor.
     */
    public function __construct()
    {
        parent::__construct("faq_questions", ["channel_id", "question", "response"]);
    }
}