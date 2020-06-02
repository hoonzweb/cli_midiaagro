<?php

namespace Source\Models;

use CoffeeCode\DataLayer\DataLayer;

/**
 * Class Email
 * @package Source\Models
 */
class Email extends DataLayer
{
    /**
     * Email constructor.
     */
    public function __construct()
    {
        parent::__construct("mail_queue", [
            "subject",
            "body",
            "from_email",
            "from_name",
            "recipient_email",
            "recipient_name"
        ]);
    }

    /**
     * @param string $subject
     * @param string $body
     * @param string $from_email
     * @param string $from_name
     * @param string $recipient_email
     * @param string $recipient_name
     * @return Email
     */
    public function add(
        string $subject,
        string $body,
        string $from_email,
        string $from_name,
        string $recipient_email,
        string $recipient_name
    ): Email {
        $this->subject = $subject;
        $this->body = $body;
        $this->from_email = $from_email;
        $this->from_name = $from_name;
        $this->recipient_email = $recipient_email;
        $this->recipient_name = $recipient_name;
        $this->save();
        return $this;
    }
}