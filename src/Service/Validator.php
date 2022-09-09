<?php

namespace App\Service;

use App\Service\Http\Request;
use App\Service\Http\Session\Session;

class Validator
{
    function __construct(private readonly Session $session)
    {
    }

    function inputTextIsValid(string $fieldName, ?string $value, int $min = null, int $max = null, bool $speChar = true): bool
    {
        $valid = true;

        if (!$value) {
            $this->session->addFlashes("danger", "Merci de renseigner votre " . $fieldName . ".");
            $valid = false;
        } else {
            if (!$speChar) {
                if (!preg_match("/^[a-zA-ZáàâäãåçéèêëíìîïñóòôöõúùûüýÿæœÁÀÂÄÃÅÇÉÈÊËÍÌÎÏÑÓÒÔÖÕÚÙÛÜÝŸÆŒ]+$/i", $value)) {
                    $valid = false;
                    $this->session->addFlashes("danger", "Certains caractères utilisés sur le champ " . $fieldName . " ne sont pas valides. Seul les caractères spéciaux suivants sont autorisés : (á,à,â,ä,ã,å,ç,é,è,ê,ë,í,ì,î,ï,ñ,ó,ò,ô,ö,õ,ú,ù,û,ü,ý,ÿ,æ,œ) en minuscule ou majuscule.");
                }
            }
            if ($min && strlen($value) < $min) {
                $valid = false;
                $this->session->addFlashes("danger", "Le champ " . $fieldName . " doit comporter plus de " . $min . " caractères.");
            }
            if ($max && strlen($value) > $max) {
                $valid = false;
                $this->session->addFlashes("danger", "Le champ " . $fieldName . " doit comporter moins de " . $max . " caractères.");
            }
        }
        return $valid;
    }

    function inputEmailIsValid(?string $value): bool
    {
        $valid = true;
        if (!$value) {
            $this->session->addFlashes("danger", "Merci de renseigner votre adresse email.");
            $valid = false;
        }
        if ($value && !preg_match("/^[-.\w]+@([\w-]+\.)+[-\w]{2,4}$/i", $value)) {
            $this->session->addFlashes("danger", "Email invalide.");
            $valid = false;
        }
        return $valid;
    }

    function inputCheckBoxIsChecked(?string $value, string $expectedName): bool
    {
        if ($value !== $expectedName) {
            $this->session->addFlashes("danger", "Veuillez accepter nos politiques de confidentialité.");
            return false;
        }
        return true;
    }

    public function formContactIsValid(Request $request): bool
    {
        $nomIsValid = $this->inputTextIsValid("nom", $request->request()->get('nom'), 1, 50, false);
        $prenomIsValid = $this->inputTextIsValid("prénom", $request->request()->get('prenom'), 2, 50, false);
        $emailIsValid = $this->inputEmailIsValid($request->request()->get('email'));
        $messageIsValid = $this->inputTextIsValid("message", $request->request()->get('message'), 10);
        $acceptedconfidentiality = $this->inputCheckBoxIsChecked($request->request()->get('confidentialite'), "accept");
        if ($nomIsValid && $prenomIsValid && $emailIsValid && $messageIsValid && $acceptedconfidentiality) {
            return true;
        }
        return false;
    }

    public function formAddCommentIsValid(Request $request): bool
    {
        $commentIsValid = $this->inputTextIsValid("commentaire", $request->request()->get('commentaire'), 10);
        if ($commentIsValid) {
            return true;
        }
        return false;
    }
}
