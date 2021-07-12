<?php

namespace App\Controllers;

use App\Core\Attributes\Route;
use App\Core\Classes\Mail;
use App\Core\Classes\SuperGlobals\Request;
use App\Core\System\Controller;
use App\Core\Classes\Validator;
use App\Core\Classes\Token;
use App\Models\BanModel;
use App\Models\UserModel;

final class LoginController extends Controller {

    #[Route('/login', 'login', ['GET', 'POST'])] public function index(Request $request) {
        if ($this->isAuthenticated()) ErrorController::error404();

        $user = new UserModel();
        $ban = new BanModel();
        $validator = new Validator($_POST);

        if ($validator->isSubmitted()) {
            if ($request->post->exists('recovery-email')) {
                $recover_user = $user->findOneBy([
                    'email' => $request->post->get('recovery-email')
                ]);

                if (!$recover_user) {
                    $this->addFlash('error', "Nous n'avons pas trouvé d'utilisateur avec cette adresse mail.");
                    $this->redirect(self::reverse('login'));
                }

                if (empty($recover_user->getPassword())) {
                    $this->addFlash('error', "Vous ne pouvez pas faire cette opération en étant inscris avec un compte Google.");
                    $this->redirect(self::reverse('login'));
                }

                $mail = new Mail(
                    Validator::filter($request->post->get('recovery-email')), 'Votre récupération de mot de passe chez HotHotHot !', dirname(__DIR__) . '/Views/email/recover.php'
                );

                $timestamp = time();
                $user_id = $recover_user->getId();

                if (!$mail->send([
                    'uri' => $this->getActualUri('recovery'),
                    'timestamp' => $timestamp,
                    'user_id' => $user_id
                ])) {
                    $this->addFlash('error', "L'e-mail de confirmation du compte n'a pas pu être envoyé.");
                } else {
                    $this->addFlash('success', "Un e-mail de récupération de mot de passe vous a été envoyé à l'adresse e-mail : {$request->post->get('recovery-email')}");
                    $this->redirect(self::reverse('login'));
                }
            }

            $data = $user->findOneBy([
                'email' => $request->post->get('email')
            ]);

            if (!empty($data)) {
                if (!is_null($data->getIdGoogle())) {
                    $this->addFlash('error', 'Cette adresse e-mail a été utilisé avec Google !');
                    $this->redirect(self::reverse('login'));
                }
            }

            $data_ban = $ban->findOneBy([
                'ip' => $_SERVER['REMOTE_ADDR']
            ]);

            // Bloquer l'utilisateur pendant un certain temps quand il échoue de se connecter plusieurs fois d'affilé
            if ($data_ban && $data_ban->getAttempt() === 5) {
                if (time() - $data_ban->getTime() < (60 * 1)) {
                    $this->addFlash('error', 'Veuillez attendre ' . 60 - (time() - $data_ban->getTime()) . ' seconde(s) avant de réessayer !');
                    $this->redirect(self::reverse('login'));
                } else {
                    $data_ban->delete($data_ban->getId());
                }
            }

            $validator->validate([
                'email' => ['email', 'required'],
                'password' => ['required']
            ]);

            $validator->customErrors([
                'email.0' => 'Vous devez informer un email valide !'
            ]);

            if (!empty($data)) {
                $email = $data->getEmail();
                $password = $data->getPassword();
            }

            $matchValue = $validator->matchValue([
                'email' => $email ??= null
            ]);

            if ($validator->isSuccess() && $matchValue && password_verify($request->post->get('password'), $password)) {
                if ($data->isIsVerified() == 0) {
                    $error = 'Veuillez vérifier votre compte !';
                } else {
                    $token = Token::generate();

                    $user->setToken($token)
                        ->setLastConnection(date("Y-m-d H:i:s", time()))
                        ->setNbConnection($data->getNbConnection() + 1)
                        ->update($data->getId());

                    $request->cookie->set('token', $token);
                    foreach ($this->getGetter($data) as $k => $v) $request->session->set($k, $v);
                    if (!$request->session->exists('last_name')) $request->session->set('last_name', ' ');

                    if (!empty($data_ban)) $data_ban->delete($data_ban->getId());

                    $this->addFlash('success', "Bienvenue {$data->getFirstName()} {$data->getLastName()} !");
                    $this->redirect(self::reverse('home'));
                }
            } else {
                if (empty($data_ban)) {
                    $ban->setIp($_SERVER['REMOTE_ADDR'])
                        ->setAttempt(1)
                        ->setTime(time())
                        ->create();
                } else {
                    $ban->setAttempt($data_ban->getAttempt() + 1)
                        ->setTime(time())
                        ->update($data_ban->getId());
                }

                $error = $validator->displayErrors(['Votre email ou votre mot de passe est invalide !']);
            }
        }

        $this->render(name_file: 'account/login', params: [
            'error' => $error ??= null
        ], title: 'Connexion', caching: false);
    }

    #[Route('/ajax/googleLogin', 'login.google', 'POST')] public function google(Request $request) {
        $user = new UserModel();
        $payload = $this->googleData($_POST['id_token']);

        if ($payload) {
            $data = $user->findOneBy([
                'email' => $payload['email'] ??= null
            ]);

            if (empty($data)) {
                $this->addFlash('error', 'Cette adresse e-mail n\'a jamais été utilisé pour se connecter à ce site !');
            } else {
                if (is_null($data->getIdGoogle())) {
                    $this->addFlash('error', 'Cette adresse e-mail est déjà utilisé sur un de vos comptes !');
                } else {
                    $token = Token::generate();

                    $user->setToken($token)
                        ->setLastConnection(date("Y-m-d H:i:s", time()))
                        ->setNbConnection($data->getNbConnection() + 1)
                        ->update($data->getId());

                    $request->cookie->set('token', $token, '/');
                    foreach ($this->getGetter($data) as $k => $v) $request->session->set($k, $v);

                    $this->addFlash('success', "Bienvenue {$payload['given_name']} {$payload['family_name']} !");
                }
            }
        } else {
            $this->addFlash('error', "Erreur lors de la connexion avec Google !");
        }
    }
}
