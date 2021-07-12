<?php

namespace App\Controllers;

use App\Core\Attributes\Route;
use App\Core\Classes\SuperGlobals\Request;
use App\Core\Classes\Validator;
use App\Core\System\Controller;
use App\Models\CommentModel;
use App\Models\DocumentationModel;
use App\Models\UserModel;
use ChrisKonnertz\BBCode\BBCode;

final class HelpController extends Controller {

    #[Route('/help', 'help')] public function index() {
        $this->data_page('help', "Documentation Utilisateur");
    }

    #[Route('/help/framework', 'framework')] public function framework() {
        if (!$this->isAuthenticated()) {
            $this->addFlash('error', 'Vous devez être connecté pour pouvoir accéder à cette page !');
            $this->redirect(self::reverse('login'));
        }

        $this->data_page('framework', "Documentation Framework");
    }

    #[Route('/help/edition', 'edition', ['GET', 'POST'])] public function edition(Request $request) {
        require_once dirname(__DIR__) . '/Core/Classes/lib/BBCode/vendor/autoload.php';

        $validator = new Validator($_POST);
        $documentations = new CommentModel();
        $users = new UserModel();
        $bbcode = new BBCode();

        if ($validator->isSubmitted('remove-edition')) {
            $doc = $documentations->findById($request->post->get('id'));
            $doc_id = $doc->getUserId();

            $documentations->delete($request->post->get('id'));

            if ($doc_id == $_SESSION['id']) {
                $this->addFlash('success', "Votre message à bien été supprimé.");
            } else {
                $this->addFlash('success', "Le message à bien été supprimé.");
            }
        }

        $documentations = $documentations->findAll();

        $data = [];

        foreach ($documentations as $documentation) {
            $parse = $bbcode->render($documentation->getContent());
            $user = $users->findOneBy([
                'id' => $documentation->getUserId()
            ]);
            if(!empty($parse)) {
                $data[] = [
                    'id' => $documentation->getId(),
                    'user_id' => $documentation->getUserId(),
                    'username' => $user->getFirstName(),
                    'title' => $documentation->getTitle(),
                    'content' => $parse,
                    'date' => $documentation->getCreatedAt()
                ];
            }
        }

        $this->render(name_file: 'other/edition', params: [
            'documentations'=> $data
        ], title: "Édition", caching: false);
    }

    #[Route('/help/editor', 'editor', ['GET', 'POST'])] public function editor(Request $request) {
        if (!$this->isAuthenticated()) {
            $this->addFlash('error', 'Vous devez être connecté pour pouvoir accéder à cette page !');
            $this->redirect(self::reverse('login'));
        }

        $validator = new Validator($_POST);
        $documentation = new DocumentationModel();
        $comment = new CommentModel();

        if(isset($_GET['page'])) {
            $content = $documentation->findOneBy([
                'page' => $_GET['page']
            ]);

            if (!empty($content) && $_SESSION['role_id'] ??= -1 === 1) {
                $data = [
                    'id' => $content->getId(),
                    'title' => $content->getTitle(),
                    'content_raw' => $content->getContent()
                ];

                $this->render(name_file: 'other/editor', params: [
                    'editor' => $data
                ], title: "Éditeur");
            } else {
                $this->redirect(self::reverse('editor'));
            }
        } elseif (isset($_GET['comment'])) {
            $content = $comment->findById($_GET['comment']);

            if (!empty($content) && $_SESSION['id'] === $content->getUserId()) {
                $data = [
                    'id' => $content->getId(),
                    'title' => $content->getTitle(),
                    'content_raw' => $content->getContent()
                ];

                $this->render(name_file: 'other/editor', params: [
                    'editor' => $data
                ], title: "Éditeur");
            } else {
                $this->addFlash('error', "N'essayez pas de modifier un commentaire qui n'est pas le votre !");
                $this->redirect(self::reverse('editor'));
            }
        } else {
            $this->render(name_file: 'other/editor', title: "Éditeur");
        }

        if ($validator->isSubmitted('documentation')) {
            if (isset($_GET['page']) && $_SESSION['role_id'] ??= -1 === 1) {
                $documentation->setUsername($_SESSION['first_name'])
                    ->setTitle($request->post->get('title'))
                    ->setContent($request->post->get('documentation'))
                    ->setUpdatedAt(date("Y-m-d H:i:s", time()))
                    ->update($request->post->get('id'));

                $this->addFlash('success', "La documentation à été modifiée.");
                $this->redirect(self::reverse($_GET['page']));
            } elseif (isset($_GET['comment']) && $_SESSION['role_id'] ??= -1 === 1) {
                $comment->setTitle($request->post->get('title'))
                    ->setContent($request->post->get('documentation'))
                    ->update($request->post->get('id'));

                $this->addFlash('success', "Votre message à été modifié.");
                $this->redirect(self::reverse('edition'));
            } else {
                $comment->setUserId($_SESSION['id'])
                    ->setTitle($_POST['title'])
                    ->setContent($_POST['documentation'])
                    ->create();

                $this->addFlash('success', "Votre message à été ajouté.");
                $this->redirect(self::reverse('edition'));
            }
        }
    }

    #[Route('/cgu', 'cgu')] public function gcu() {
        $this->data_page('cgu', "Conditions Générales d'Utilisation (CGU)");
    }

    #[Route('/mentions-legales', 'mentions-legales')] public function legal_notices() {
        $this->data_page('mentions-legales', "Mentions légales");
    }

    private function data_page(string $route, string $title) {
        require_once dirname(__DIR__) . '/Core/Classes/lib/BBCode/vendor/autoload.php';

        $documentation = new DocumentationModel();
        $bbcode = new BBCode();

        $content = $documentation->findOneBy([
            'page' => $route
        ]);

        $data = [
            'username' => $content->getUsername(),
            'page' => $content->getPage(),
            'title' => $content->getTitle(),
            'content' => $bbcode->render($content->getContent()),
            'updated_at' => $content->getUpdatedAt()
        ];

        $this->render(name_file: 'other/documentation', params: [
            'documentation' => $data
        ], title: $title);
    }
}
