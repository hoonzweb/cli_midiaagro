<?php

namespace Source\Models;

use CoffeeCode\DataLayer\DataLayer;
use Source\Core\View;
use Source\Support\Message;
use Source\Support\Email;

/**
 * Class Newsletter
 * @package Source\Models
 */
class Newsletter extends DataLayer
{
    /**
     * @var Message
     */
    protected $message;

    /**
     * Newsletter constructor.
     */
    public function __construct()
    {
        parent::__construct("newsletter", ["name", "email"]);
        $this->message = new Message();
    }

    /**
     * @param string $name
     * @param string $email
     * @return Newsletter
     */
    public function bootstrap(string $name, string $email): Newsletter
    {
        $this->name = $name;
        $this->email = $email;
        return $this;
    }

    /**
     * @param string $Email
     * @param string $columns
     * @return Newsletter|null
     */
    public function findByEmail(string $Email, string $columns = "*"): ?Newsletter
    {
        $find = $this->find("email = :e", "e={$Email}", $columns);
        return $find->fetch();
    }

    /**
     * @return bool
     */
    public function save(): bool
    {
        if ($this->checkMail() && empty($this->id)) {
            $this->message->warning("Esse e-mail já está cadastrado em nossa lista!");
            return false;
        }

        if (!parent::save()) {
            $this->message->warning($this->fail()->getMessage());
            return false;
        }

        if ($this->status != "confirmed") {
            $view = new View(__DIR__ . "/../../shared/views/email");
            $message = $view->render("confirm", [
                "first_name" => $this->name,
                "message" => "Confirme seu e-mail para ativar o recebimento de conteúdos exclusivos!",
                "confirm_link" => url("/obrigado/" . base64_encode($this->email) . "/lead")
            ]);

            (new Email())->bootstrap(
                "Ative seu e-mail na " . CONF_SITE_NAME,
                $message,
                $this->email,
                "{$this->name}"
            )->queue();
        }

        return true;
    }

    /**
     * @return bool
     */
    private function checkMail(): bool
    {
        $checkMail = $this->find("email = :e", "e={$this->email}")->count();
        if ($checkMail >= 1) {
            return true;
        }

        return false;
    }

    /**
     * @return Message|null
     */
    public function message(): ?Message
    {
        return $this->message;
    }
}