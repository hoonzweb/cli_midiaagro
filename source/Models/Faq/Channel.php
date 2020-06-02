<?php

namespace Source\Models\Faq;

use CoffeeCode\DataLayer\DataLayer;

/**
 * Class Channel
 * @package Source\Models\Faq
 */
class Channel extends DataLayer
{
    /**
     * Channel constructor.
     */
    public function __construct()
    {
        parent::__construct("faq_channels", ["channel", "description"]);
    }

    /**
     * @return Question
     */
    public function questions(): Question
    {
        return (new Question())->find("channel_id = :id", "id={$this->id}");
    }
}