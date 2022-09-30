<?php

declare(strict_types=1);

namespace App\Service\Validator;

use App\Service\Http\Request;

class FormValidator extends Validator
{
    public function formContactIsValid(Request $request): bool
    {
        $nomIsValid = $this->inputTextIsValid("nom", $request->request()->get('nom'), 1, 50, false);
        $prenomIsValid = $this->inputTextIsValid("prénom", $request->request()->get('prenom'), 2, 50, false);
        $emailIsValid = $this->inputEmailIsValid($request->request()->get('email'));
        $messageIsValid = $this->inputTextIsValid("message", $request->request()->get('message'), 10);
        $acceptedPrivacy = $this->inputCheckBoxIsChecked($request->request()->get('confidentialite'), "accept");
        if ($nomIsValid && $prenomIsValid && $emailIsValid && $messageIsValid && $acceptedPrivacy) {
            return true;
        }
        return false;
    }

    public function formAddCommentIsValid(Request $request): bool
    {
        if (!$request->request()->has('commentaire')) {
            $this->session->addFlashes("danger", "Désolé le formulaire n'est pas complet.");
            return false;
        }
        $commentIsValid = $this->inputTextIsValid("commentaire", $request->request()->get('commentaire'), 10);
        if ($commentIsValid) {
            return true;
        }
        return false;
    }

    public function formRegisterIsValid(Request $request): bool
    {
        $nomIsValid = $this->inputTextIsValid("pseudo", $request->request()->get('pseudo'), 3, 50);
        $pseudoIsUnique = $this->attributeIsUnique("pseudo", ["pseudo" => $request->request()->get('pseudo')]);
        $emailIsValid = $this->inputEmailIsValid($request->request()->get('email'));
        $emailIsUnique = $this->attributeIsUnique("email", ["email" => $request->request()->get('email')]);
        $acceptedPrivacy = $this->inputCheckBoxIsChecked($request->request()->get('confidentialite'), "accept");
        $formatPasswordIsValid = $this->formatPasswordIsValid($request->request()->get('password'), $request->request()->get('confirm_password'));

        if ($nomIsValid && $emailIsValid && $acceptedPrivacy && $formatPasswordIsValid && $emailIsUnique && $pseudoIsUnique) {
            return true;
        }
        return false;
    }

    public function formEditArticleIsValid(Request $request): bool
    {
        $titleIsValid = $this->inputTextIsValid("titre", $request->request()->get('title'), 3, 250);
        $chapoIsValid = $this->inputTextIsValid("chapô", $request->request()->get('chapo'), 10, 255);
        $contentIsValid = $this->inputTextIsValid("contenu", $request->request()->get('content'), 10);
        $author = $this->userRepository->find((int)$request->request()->get('author'));
        if ($titleIsValid && $chapoIsValid && $contentIsValid && $author != null) {
            return true;
        }
        return false;
    }

    public function formNewArticleIsValid(Request $request): bool
    {
        $titleIsValid = $this->inputTextIsValid("titre", $request->request()->get('title'), 3, 250);
        $chapoIsValid = $this->inputTextIsValid("chapô", $request->request()->get('chapo'), 10, 255);
        $contentIsValid = $this->inputTextIsValid("contenu", $request->request()->get('content'), 10);
        if ($titleIsValid && $chapoIsValid && $contentIsValid) {
            return true;
        }
        return false;
    }
}
