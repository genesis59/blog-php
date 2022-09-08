<?php

namespace App\Service;

use App\Service\Http\Session\Session;
use App\View\View;
use Swift_Mailer;
use Swift_SmtpTransport;

class MailerService
{
    private Swift_Mailer $mailer;

    /**
     * @param string $host
     * @param int $port
     * @param Session $session
     * @param View $view
     */
    public function __construct(string $host, int $port, private readonly Session $session, private readonly View $view)
    {
        $this->mailer = new Swift_Mailer(new Swift_SmtpTransport($host, $port));
    }

    public function sendContactEmail(string $from, string $message, string $nom, string $prenom): void
    {
        try {
            $email = (new \Swift_Message('Contact blog php'))
                ->setFrom($from)
                ->setTo('gvandevray@numericable.fr')
                ->setBody($this->view->render([
                    'template' => 'mail/contact',
                    'prenom' => $prenom,
                    'nom' => $nom,
                    'message' => $message
                ]), "text/html", "UTF-8");
            $this->mailer->send($email);
            $this->session->addFlashes("success", "message envoyé");
        } catch (\Exception $e) {
            $this->session->addFlashes("danger", $e->getMessage());
        }
    }
}
