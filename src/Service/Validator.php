<?php

namespace App\Service;

use App\Service\Http\Session\Session;

class Validator
{
    function __construct(private readonly Session $session)
    {
    }

    function inputTextIsValid(string $fieldName, ?string $value, int $min = null, int $max = null): bool
    {
        $valid = true;
        if (!$value) {
            $this->session->addFlashes("danger", "Merci de renseigner votre " . $fieldName . ".");
            $valid = false;
        } else {
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
            $this->session->addFlashes("danger", "Email invalides.");
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
}
