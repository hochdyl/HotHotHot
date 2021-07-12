<?php

namespace App\Controllers;

use App\Core\Attributes\Route;
use App\Core\System\Controller;
use App\Models\SensorModel;
use App\Models\Sensor_DataModel;
use App\Models\Sensor_TypeModel;
use JetBrains\PhpStorm\NoReturn;
use Net_SSH2;

class SensorsController extends Controller {

    #[Route('/sync', 'sync')] public function index() {
        $sensors = new SensorModel();
        $sensor_data = new Sensor_DataModel();
        $sensor_types = new Sensor_TypeModel();

        foreach (SENSORS_LINK as $url) {
            $data = $this->data($url);

            if (!empty($data)) {
                $sensor = $sensors->findOneBy([
                    'name' => $data['capteurs'][0]['Nom']
                ]);

                if (empty($sensor)) {
                    $sensor_type = $sensor_types->findOneBy([
                        'name' => $data['capteurs'][0]['type']
                    ]);

                    if (empty($sensor_type)) {
                        $sensor_types->setName($data['capteurs'][0]['type'])
                            ->create();

                        $sensor_type = $sensor_types->findOneBy([
                            'name' => $data['capteurs'][0]['type']
                        ]);
                    }

                    $sensors->setTypeId($sensor_type->getId())
                        ->setName($data['capteurs'][0]['Nom'])
                        ->setActive(1)
                        ->create();

                    $sensor = $sensors->findOneBy([
                        'name' => $data['capteurs'][0]['Nom']
                    ]);
                }

                $sensor_data->setSensorId($sensor->getId())
                    ->setTemperature($data['capteurs'][0]['Valeur'])
                    ->create();
            }
        }

        $this->get($_SESSION['nb_values_comparison'] ??= SENSORS_DEFAULT_NB_VALUE_COMPARISON);
        $this->crontab();
    }

    public static function get(int $nb_value) {
        $sensors = new SensorModel();
        $sensor_data = new Sensor_DataModel();
        $sensor_types = new Sensor_TypeModel();

        $list = $sensors->findAll();

        $i = 0;
        $data = [];

        foreach ($list as $sensor) {
            $type = $sensor_types->findOneBy([
                'id' => $sensor->getTypeId()
            ]);

            $data[$i]['id'] = $sensor->getId();
            $data[$i]['name'] = $sensor->getName();
            $data[$i]['type'] = $type->getName();

            $data[$i]['data'] = $sensor_data->findByLimit([
                'sensor_id' => $sensor->getId()
            ], 'id', $nb_value);

            $i++;
        }

        define('SENSORS_DATA', json_encode($data));
        define('SENSORS_NUMBER', count($list));
    }

    public static function crontab() {
        if (PHP_OS != 'Linux') exit("Le site web ne tourne pas sous Linux.");
        if (SENSORS_SYNC_TIME < 0) exit("Temps de synchronisation négatif");

        require_once dirname(__DIR__) . '/Core/Classes/lib/phpseclib/Net/SSH2.php';
        set_include_path(get_include_path() . PATH_SEPARATOR . 'phpseclib');

        $ssh = new NET_SSH2(SSH_HOST, SSH_PORT);
        if (!$ssh->login(SSH_USER, SSH_PASS)) {
            exit('Login Failed');
        }

        if (SENSORS_SYNC_TIME == 0) {
            $ssh->exec('echo "* * * * * /bin/curl https://hothothot.minarox.fr/sync" | crontab -');
        } elseif (SENSORS_SYNC_TIME <= 59) {
            echo $ssh->exec('echo "*/'.SENSORS_SYNC_TIME.' * * * * /bin/curl https://hothothot.minarox.fr/sync" | crontab -');
        } else {
            $hours = (int) floor(SENSORS_SYNC_TIME / 60);
            $minutes = (SENSORS_SYNC_TIME % 60);
            $ssh->exec('echo "*/'.$minutes.' */'.$hours.' * * * /bin/curl https://hothothot.minarox.fr/sync" | crontab -');
        }
    }

    private function data(string $url) {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:19.0) Gecko/20100101 Firefox/19.0');
        $content = curl_exec($ch);
        curl_close($ch);

        return json_decode($content, true);
    }

}
