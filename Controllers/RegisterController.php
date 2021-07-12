<?php

namespace App\Controllers;

use App\Core\Attributes\Route;
use App\Core\Classes\Mail;
use App\Core\Classes\SuperGlobals\Request;
use App\Core\System\Controller;
use App\Core\Classes\Validator;
use App\Core\Classes\Token;
use App\Models\AlertModel;
use App\Models\SensorModel;
use App\Models\UserModel;
use App\Models\RoleModel;

final class RegisterController extends Controller {

    #[Route('/register', 'register', ['GET', 'POST'])] public function index(Request $request) {
        if ($this->isAuthenticated()) ErrorController::error404();

        $user = new UserModel();
        $role = new RoleModel();
        $validator = new Validator($_POST);

        if ($validator->isSubmitted()) {
            $email_post = $request->post->get('email');

            $data = $user->findOneBy([
                'email' => $email_post ??= null
            ]);

            $validator->validate([
                'anti_bot' => ['empty'],
                'last_name' => ['required', 'alpha'],
                'first_name' => ['required'],
                'email' => ['email', 'required'],
                'password' => ['required', "equal:{$request->post->get('password_verify')}"],
                'password_verify' => ['required'],
                'cgu_check' => ['required']
            ]);

            if (!empty($data)) $email = $data->getEmail();

            $matchValue = $validator->matchValue([
                'email' => $email ??= null,
            ]);

            if ($validator->isSuccess() && !$matchValue) {
                $mail = new Mail(
                    Validator::filter($email_post), 'Votre Inscription chez HotHotHot !', dirname(__DIR__) . '/Views/email/register.php'
                );

                $token = Token::generate();

                if (!$mail->send([
                    'token' => $token,
                    'uri' => $this->getActualUri('email/register')
                ])) {
                    $this->addFlash('error', "L'e-mail de confirmation du compte n'a pas pu être envoyé !");
                    $this->redirect(self::reverse('register'));
                }

                $user->setLastName(Validator::filter($request->post->get('last_name')))
                    ->setfirstName(Validator::filter($request->post->get('first_name')))
                    ->setEmail(Validator::filter($email_post))
                    ->setPassword(password_hash($request->post->get('password'), PASSWORD_ARGON2I))
                    ->setRoleId($role->findById(2)->getId())
                    ->setToken($token)
                    ->setNbValuesSensors(SENSORS_DEFAULT_NB_VALUE)
                    ->setNbValuesComparison(SENSORS_DEFAULT_NB_VALUE_COMPARISON)
                    ->create();

                $new_user = $user->findOneBy([
                    'token' => $token
                ]);

                $this->add_alerts($new_user->getId());

                $this->addFlash('success', "Un email de confirmation vous a été envoyé à l'adresse e-mail : {$email_post}");
                $this->redirect(self::reverse('login'));
            } else {
                $matchValue ? $this->addFlash('error', $validator->displayErrors(['Cette e-mail est déjà utilisé !'])) : $this->addFlash('error', $validator->displayErrors());
                $this->redirect(self::reverse('login'));
            }
        }

        $this->render(name_file: 'account/register', params: [
            'error' => $error ??= null
        ], title: 'Inscription', caching: false);
    }

    #[Route('/ajax/googleRegister', 'register.google', 'POST')] public function google(Request $request) {
        $user = new UserModel();
        $role = new RoleModel();

        $payload = $this->googleData($request->post->get('id_token'));

        if ($payload) {
            $data = $user->findOneBy([
                'email' => $payload['email'] ??= null
            ]);

            if (!empty($data)) {
                $this->addFlash('error', 'Cette adresse e-mail a déjà été utilisé pour se connecter à ce site !');
            } else {
                $token = Token::generate();

                $user->setIdGoogle((int) $payload['sub'])
                    ->setLastName($payload['family_name'])
                    ->setfirstName($payload['given_name'])
                    ->setEmail($payload['email'])
                    ->setIsVerified(1)
                    ->setAvatar($payload['picture'])
                    ->setRoleId($role->findById(2)->getId())
                    ->setLastConnection(date("Y-m-d H:i:s", time()))
                    ->setNbConnection(1)
                    ->setToken($token)
                    ->setNbValuesSensors(SENSORS_DEFAULT_NB_VALUE)
                    ->setNbValuesComparison(SENSORS_DEFAULT_NB_VALUE_COMPARISON)
                    ->create();

                $new_user = $user->findOneBy([
                    'token' => $token
                ]);

                $this->add_alerts($new_user->getId());

                $request->session->set('id', $new_user->getId());
                $request->session->set('id_google', $new_user->getIdGoogle());
                $request->session->set('last_name', $payload['family_name']);
                $request->session->set('first_name', $payload['given_name']);
                $request->session->set('email', $payload['email']);
                $request->session->set('avatar', $payload['picture']);
                $request->session->set('token', $token);
                $request->session->set('created_at', date("Y-m-d H:i:s"));

                $request->cookie->set('token', $token, '/');

                $this->addFlash('success', "Bienvenue {$payload['given_name']} {$payload['family_name']} !");
            }
        } else {
            $this->addFlash('error', "Erreur lors de l'inscription avec Google !");
        }
    }

    public function add_alerts(int $user_id) {
        $alerts_file = file_get_contents(dirname(__DIR__) . '/' . SENSORS_DEFAULT_ALERTS);
        $alerts_array = json_decode($alerts_file, true);

        $sensors = new SensorModel();
        $alert_model = new AlertModel();
        $operator = 0;

        foreach ($alerts_array as $sensor_name) {
            $sensor = $sensors->findOneBy([
                'name' => $sensor_name['sensor_name']
            ]);

            foreach ($sensor_name['alerts'] as $alert) {
                if ($alert['operator'] == '>') {
                    $operator = 1;
                } elseif ($alert['operator'] == '=>') {
                    $operator = 2;
                } elseif ($alert['operator'] == '=') {
                    $operator = 3;
                } elseif ($alert['operator'] == '<=') {
                    $operator = 4;
                } elseif ($alert['operator'] == '<') {
                    $operator = 5;
                }

                $alert_model->setSensorId($sensor->getId())
                    ->setUserId($user_id)
                    ->setName($alert['name'])
                    ->setDescription($alert['description'])
                    ->setOperator($operator)
                    ->setValue($alert['value'])
                    ->create();
            }
        }
    }

}
