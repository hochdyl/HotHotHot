<?php

namespace App\Controllers;

use App\Core\Attributes\Route;
use App\Core\Classes\SuperGlobals\Request;
use App\Core\Classes\Validator;
use App\Core\System\Controller;
use App\Models\AlertModel;
use App\Models\SensorModel;
use App\Models\UserModel;

final class SettingsController extends Controller {

    #[Route('/settings', 'settings', ['GET', 'POST'])] public function index(Request $request) {
        if (!$this->isAuthenticated()) {
            $this->addFlash('error', 'Vous devez être connecté pour accéder à la page de paramètre !');
            $this->redirect(self::reverse('login'));
        }

        $validator = new Validator($_POST);
        $user = new UserModel();
        $alert = new AlertModel();
        $sensors = new SensorModel();

        if ($validator->isSubmitted('update-parameters')) {

            $validator->validate([
                'value-sensors' => ['required', 'int'],
                'value-comparison' => ['required', 'int']
            ]);

            if ($validator->isSuccess()) {
                if ($request->post->get('value-sensors') > $request->post->get('value-comparison')) {
                    $this->addFlash('error', 'Le nombre de données à comparer doit être supérieur au nombre de donnée par capteur !');
                    $this->redirect(self::reverse('settings'));
                }

                $user->setNbValuesComparison($request->post->get('value-comparison'))
                    ->setNbValuesSensors($request->post->get('value-sensors'))
                    ->update($request->session->get('id'));

                $request->session->set('nb_values_sensors', $request->post->get('value-sensors'));
                $request->session->set('nb_values_comparison', $request->post->get('value-comparison'));

                $this->addFlash('success', 'Les paramètres ont bien été modifiées !');
                $this->redirect(self::reverse('settings'));
            } else {
                $error = $validator->displayErrors();
            }
        }

        if ($validator->isSubmitted('add-alert')) {

            $validator->validate([
                'sensor-id-new-alert' => ['required', 'int'],
                'name-new-alert' => ['required'],
                'description-new-alert' => ['required'],
                'operator-new-alert' => ['required', 'int'],
                'value-new-alert' => ['required', 'int']
            ]);

            if ($validator->isSuccess()) {
                $alert->setSensorId(Validator::filter($request->post->get('sensor-id-new-alert')))
                    ->setUserId($request->session->get('id'))
                    ->setName(Validator::filter($request->post->get('name-new-alert')))
                    ->setDescription(Validator::filter($request->post->get('description-new-alert')))
                    ->setOperator(Validator::filter($request->post->get('operator-new-alert')))
                    ->setValue(Validator::filter($request->post->get('value-new-alert')))
                    ->create();

                $sensor = $sensors->findById($request->post->get('sensor-id-new-alert'));

                $this->addFlash('success', 'L\'alerte à bien été ajoutée sur le capteur "'. $sensor->getName() .'" !');
                $this->redirect(self::reverse('settings'));
            } else {
                $error = $validator->displayErrors();
            }
        }

        if ($validator->isSubmitted('delete-alert-sensor' . $request->post->get('sensor-id-new-alert'))) {
            $alert->delete($request->session->get('alert_id'));

            $request->session->delete('alert_id');

            $this->addFlash('success', 'L\'alerte "' . $request->post->get("name-alert-sensor" . $request->post->get('sensor-id-new-alert')) . '" a bien été supprimée !');
            $this->redirect(self::reverse('settings'));
        }

        if ($validator->isSubmitted('update-alert-sensor' . $request->post->get('sensor-id-new-alert'))) {

            $sensor_id = $request->post->get('sensor-id-new-alert');

            $validator->validate([
                'name-alert-sensor' . $sensor_id => ['required'],
                'description-new-alert' . $sensor_id => ['required'],
                'operator-alert-sensor' . $sensor_id => ['required'],
                'value-alert-sensor' . $sensor_id => ['required', 'int']
            ]);

            if ($validator->isSuccess()) {

                $alert->setName($request->post->get("name-alert-sensor$sensor_id"))
                    ->setDescription($request->post->get("description-new-alert$sensor_id"))
                    ->setOperator($request->post->get("operator-alert-sensor$sensor_id"))
                    ->setValue($request->post->get("value-alert-sensor$sensor_id"))
                    ->update($request->session->get('alert_id'));

                $request->session->delete('alert_id');

                $this->addFlash('success', 'Les données de l\'alerte "' . $request->post->get("name-alert-sensor$sensor_id") . '" ont bien été modifiée !');
                $this->redirect(self::reverse('settings'));
            } else {
                $error = $validator->displayErrors();
            }
        }

        $this->render(name_file: 'other/settings', params: [
            'error' => $error ??= null
        ], title: 'Paramétrages', caching: false);
    }

    public static function id(int $id): array {
        $alert = new AlertModel();
        $alerts = $alert->findBy([
            'user_id' => $_SESSION['id'],
            'sensor_id' => $id
        ]);

        $alert_list = [];
        $i = 0;

        foreach ($alerts as $alert) {
            $alert_list[$i]['id'] = $alert->getId();
            $alert_list[$i]['name'] = $alert->getName();
            $i++;
        }

        return $alert_list;
    }

    #[Route('/ajax/alertSensor', 'settings.alert', 'POST')] public function alertSensor(Request $request): void {
        $data = (new AlertModel())->findById($request->post->get('alert_id'));
        $request->session->set('alert_id', $data->getId());

        echo json_encode($this->getGetter($data));
    }

    public static function getAlert() {
        $alerts = new AlertModel();

        $list = $alerts->findBy([
            'user_id' => $_SESSION['id'] ?? null
        ]);

        $i = 0;
        $data = [];

        foreach ($list as $alert) {
            $data[$i]['sensor_id'] = $alert->getSensorId();
            $data[$i]['name'] = $alert->getName();
            $data[$i]['description'] = $alert->getDescription();
            $data[$i]['operator'] = $alert->getOperator();
            $data[$i]['value'] = $alert->getValue();
            $i++;
        }

        define('SENSORS_ALERTS', json_encode($data));
    }

    #[Route('/settings/download', 'settings.download')] public function download() {
        if(isset($_GET['sensor'])) {
            $sensor = $_GET['sensor'];
            SensorsController::get($_SESSION['nb_values_comparison'] ??= SENSORS_DEFAULT_NB_VALUE_COMPARISON);
            $data = json_decode(SENSORS_DATA, true);
            header('Content-disposition: attachment; filename=capteur_'.$data[$sensor]['name'].'.json');
            header('Content-type: application/json');
            echo json_encode($data[$sensor]);
        } else {
            $this->addFlash('error', "Une erreur est survenue lors du téléchargement des données.");
            $this->redirect(self::reverse('settings'));
        }
    }

}
