<?php

namespace App\Controllers;

use App\Core\Attributes\Route;
use App\Core\Classes\SuperGlobals\Request;
use App\Core\Classes\Validator;
use App\Core\System\Controller;
use App\Models\UserModel;

#[Route('/account')] final class ProfileController extends Controller {

    #[Route('', 'account', ['GET', 'POST'])] public function index(Request $request) {
        if (!$this->isAuthenticated()) ErrorController::error404();

        $validator = new Validator($_POST);

        if ($validator->isSubmitted()) {
            $validator->validate([
                'delete_confirm' => ['required']
            ]);

            $matchValue = $validator->matchValue([
                'delete_confirm' => 'delete ' . $request->session->get('email')
            ]);

            if ($validator->isSuccess() && $matchValue) {
                $user = new UserModel();
                $user->delete($request->session->get('id'));

                $request->cookie->delete('token');
                setcookie('token', '', time() - INACTIVITY_TIME, '/');
                $request->session->delete(restart_session: true);

                $this->addFlash('success', "Votre compte a bien été supprimée ! Au revoir {$request->session->get('first_name')} {$request->session->get('last_name')}");
                $this->redirect(self::reverse('login'));
            } else {
                $this->addFlash('error', 'Le texte que vous avez saisi pour supprimer votre compte ne correspond pas !');
                $this->redirect(self::reverse('account'));
            }
        }
        $this->render(name_file: 'account/profile', title: 'Profil', caching: false);
    }

    #[Route('/edit', 'account.edit', ['GET', 'POST'])] public function edit(Request $request) {
        if (!$this->isAuthenticated()) ErrorController::error404();
        $validator = new Validator($_POST);
        $user = new UserModel();

        if ($validator->isSubmitted('update')) {
            $validator->validate([
                'email' => ['required', 'email'],
                'first_name' => ['required'],
                'last_name' => ['required']
            ]);

            $matchValue = $validator->matchValue([
                'email' => $request->session->get('email'),
                'first_name' => $request->session->get('first_name'),
                'last_name' => $request->session->get('last_name')
            ]);

            if ($matchValue && $_FILES["file"]["error"] === 4) {
                $this->addFlash('error', "Vous n'avez pas modifié vos informations.");
                $this->redirect(self::reverse('account'));
            }

            if ($validator->isSuccess()) {
                if (isset($_FILES['file']) && $_FILES['file']['error'] === 0) {
                    $file_name = $_FILES['file']['name'];
                    $file_type = $_FILES['file']['type'];
                    $file_size = $_FILES['file']['size'];

                    $allowed = [
                        'jpg' => 'image/jpeg',
                        'jpeg' => 'image/jpeg',
                        'png' => 'image/png'
                    ];

                    $extension = strtolower(pathinfo($file_name,PATHINFO_EXTENSION));

                    if (!array_key_exists($extension, $allowed) || !in_array($file_type, $allowed)) {
                        $this->addFlash('error', "Format du fichier incorrect !");
                        $this->redirect(self::reverse('account'));
                    }

                    if ($file_size > 1024 *1024) {
                        $this->addFlash('error', "L'image est trop volumineuse et ne doit pas dépasser 1 MO !");
                        $this->redirect(self::reverse('account'));
                    }

                    // Identifiant unique pour le nom du fichier
                    $uniq_id = hash('sha256', uniqid());

                    $new_file_name = dirname(__DIR__) . "/public/assets/uploads/$uniq_id.$extension";

                    // On crée le dossier /uploads si celui-ci n'existe pas encore
                    if (!file_exists(dirname(__DIR__) . "/public/assets/uploads/")) mkdir(dirname(__DIR__) . "/public/assets/uploads/", 0755);

                    if (!move_uploaded_file($_FILES['file']['tmp_name'], $new_file_name)) {
                        $this->addFlash('error', "La sauvegarde de votre image de profil a échouée !");
                        $this->redirect(self::reverse('account'));
                    }

                    $old_avatar = $user->findById($request->session->get('id'))->getAvatar();

                    // On supprime l'ancienne image de profile s'il celle-ci existe
                    if (file_exists(dirname(__DIR__) . $old_avatar)) unlink(dirname(__DIR__) . $old_avatar);

                    // On retire les droits d'écriture et d'exécution dans le dossier /uploads pour la sécurité
                    chmod($new_file_name, 0644);

                    $user->setAvatar("/public/assets/uploads/$uniq_id.$extension")
                        ->update($request->session->get('id'));

                    // On met à jours la session pour l'image de profil
                    $request->session->set('avatar', "/public/assets/uploads/$uniq_id.$extension");
                }

                $user->setEmail(Validator::filter($request->post->get('email')))
                    ->setFirstName(Validator::filter($request->post->get('first_name')))
                    ->setLastName(Validator::filter($request->post->get('last_name')))
                    ->update($request->session->get('id'));

                // On met à jours les sessions pour afficher les modifications visuellement
                $request->session->set('email', $request->post->get('email'));
                $request->session->set('first_name', $request->post->get('first_name'));
                $request->session->set('last_name', $request->post->get('last_name'));

                $this->addFlash('success', 'Vos informations ont bien été modifiée !');
                $this->redirect(self::reverse('account'));
            } else {
                $error = $validator->displayErrors();
            }
        }

        if ($validator->isSubmitted('password_update')) {
            $old_password = $request->post->get('old_password');
            $new_password = trim($request->post->get('new_password'));
            $new_password_verify = trim($request->post->get('new_password_verify'));

            $validator->validate([
                'old_password' => ['required'],
                'new_password' => ['required', "equal:$new_password_verify"],
                'new_password_verify' => ['required']
            ]);

            $new_hash_password = password_hash($new_password, PASSWORD_ARGON2I);

            if (!password_verify($old_password, $request->session->get('password'))) {
                $this->addFlash('error', 'Votre ancien mot de passe ne correspond pas avec celui là !');
                $this->redirect(self::reverse('account.edit'));
            }

            if (password_verify($new_password, $request->session->get('password'))) {
                $this->addFlash('error', 'Soyez original ! Votre ancien mot de passe est le même !');
                $this->redirect(self::reverse('account.edit'));
            }

            if (!$validator->isSuccess()) {
                $this->addFlash('error', 'Vos mots de passe doivent correspondre !');
                $this->redirect(self::reverse('account.edit'));
            }

            $user->setPassword($new_hash_password)
                ->update($request->session->get('id'));

            $request->session->set('password', $new_hash_password);

            $this->addFlash('success', 'Vos mots de passe a bien été mis à jour !');
            $this->redirect(self::reverse('account'));
        }

        $this->render(name_file: 'account/edit-profile', params: [
            'error' => $error ??= null
        ], title: 'Profil', caching: false);
    }

}
