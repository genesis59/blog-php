<?php

namespace App\Service;

use App\Service\Http\Session\Session;
use Swift_Mailer;
use Swift_SmtpTransport;

class MailerService
{
    private Swift_Mailer $mailer;

    public function __construct(Swift_SmtpTransport $transport, private readonly Session $session)
    {
        $this->mailer = new Swift_Mailer($transport);
    }

    public function sendContactEmail(string $from, string $message, string $nom, string $prenom): void
    {
        try {
            $email = (new \Swift_Message('Contact blog php'))
                ->setFrom($from)
                ->setTo('gvandevray@numericable.fr')
                ->setBody($message . " message de " . $nom . ' ' . $prenom);
            $this->mailer->send($email);
            $this->session->addFlashes("success", "message envoyé");
        } catch (\Exception $e) {
            $this->session->addFlashes("danger", $e->getMessage());
        }
    }
}
