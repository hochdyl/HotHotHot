<?php

namespace App\Controllers;

use App\Core\Attributes\Route;
use App\Core\Classes\SuperGlobals\Request;
use App\Core\Classes\Token;
use App\Core\System\Controller;
use App\Models\UserModel;
use JetBrains\PhpStorm\NoReturn;

class EmailRegisterController extends Controller {

    #[NoReturn] #[Route('/email/register', 'email.register', ['GET', 'POST'])] public function index(Request $request) {
        if (!$request->get->exists('token_email')) ErrorController::error404();

        $user = new UserModel();

        $data = $user->findOneBy([
            'token' => $request->get->get('token_email')
        ]);

        if (!empty($data)) {

            $token = Token::generate();

            $user->setIsVerified(1)
                ->setToken($token)
                ->update($data->getId());

            $this->addFlash('success', "Votre compte a bien été vérifié ! Veuillez vous connecter avec vos identifiant :)");
            $this->redirect(self::reverse('login'));
        }

        $this->addFlash('error', "Le lien a déjà été utilisé ou est expiré !");
        $this->redirect(self::reverse('login'));
    }
}
