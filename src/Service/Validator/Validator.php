<?php

namespace App\Service\Validator;

use App\Model\Repository\UserRepository;
use App\Service\Http\Session\Session;

class Validator
{
    function __construct(
        protected readonly UserRepository $userRepository,
        protected readonly Session $session
    ) {
    }

    public function inputTextIsValid(string $fieldName, ?string $value, int $min = null, int $max = null, bool $speChar = true): bool
    {
        if (!$value) {
            $this->session->addFlashes("danger", "Merci de renseigner votre " . $fieldName . ".");
            return false;
        }
        $valid = true;
        if (!$speChar) {
            if (!preg_match("/^[a-zA-ZáàâäãåçéèêëíìîïñóòôöõúùûüýÿæœÁÀÂÄÃÅÇÉÈÊËÍÌÎÏÑÓÒÔÖÕÚÙÛÜÝŸÆŒ]+$/i", $value)) {
                $valid = false;
                $this->session->addFlashes("danger", "Champ " . $fieldName . " invalide. Les caractères spéciaux ne sont pas autorisés.");
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

        return $valid;
    }

    public function inputEmailIsValid(?string $value): bool
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

    public function inputCheckBoxIsChecked(?string $value, string $expectedName): bool
    {
        if ($value !== $expectedName) {
            $this->session->addFlashes("danger", "Veuillez accepter nos politiques de confidentialité.");
            return false;
        }
        return true;
    }

    /**
     * @param string $fieldName
     * @param array<string,string> $criteria
     * @return bool
     */
    public function attributeIsUnique(string $fieldName, array $criteria): bool
    {
        if ($this->userRepository->findOneBy($criteria) === null) {
            return true;
        }
        $this->session->addFlashes("danger", "La valeur renseigné dans le champ " . $fieldName . " n'est pas disponible.");
        return false;
    }

    public function formatPasswordIsValid(string $password, string $confirmPassword): bool
    {
        if ($password !== $confirmPassword) {
            $this->session->addFlashes("danger", "Les mots de passe renseignés sont différents.");
            return false;
        }

        if (!preg_match("/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[-.,?;:§+!*$@%_])([-.,?;:§+!*$@%_\w]{8,})$/", $password)) {
            $this->session->addFlashes("danger", "Le mot de passe n'est pas valide. Il doit comporter au moins 8 caractères dont 1 minuscule, 1 majuscule, 1 chiffre et 1 caractère spécial (-.,?;:§+!*$@%_).");
            return false;
        }
        return true;
    }
}
