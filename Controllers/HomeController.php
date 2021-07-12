<?php

namespace App\Controllers;

use App\Core\Attributes\Route;
use App\Core\System\Controller;

final class HomeController extends Controller {

    #[Route('/', 'home')] public function index() {
        SensorsController::get($_SESSION['nb_values_comparison'] ??= SENSORS_DEFAULT_NB_VALUE_COMPARISON);
        SensorsController::crontab();
        SettingsController::getAlert();

        $this->render(name_file: 'home', caching: false);
    }

}
