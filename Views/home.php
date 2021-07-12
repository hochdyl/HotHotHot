<main class="container w-xxl">
    <!-- Titre général pour l'accessibilité -->
    <h1 id="accessibility">État, valeurs et historiques des capteurs.</h1>
    <?php
    function box(int $id) {
        echo '
        <!-- Capteur -->
        <article class="col col-md col-lg m-3 mt-0 box row sensor" id="sensor'.$id.'">
            <!-- Alerte du capteur -->
            <section class="sensor-alert" id="sensor'.$id.'-alert">
                <!-- Titre et texte d\'alerte / description -->
                <h2>Alerte du capteur <span id="sensor'.$id.'-name"></span> :</h2>
                <p></p>
                <!-- Boutons de navigation de l\'alerte -->
                <button onclick="show_details_alert('.$id.', false)" class="sensor-details-btn" id="sensor'.$id.'-details-btn">Détails</button>
                <button onclick="show_details_alert('.$id.', true)" class="sensor-back-btn" id="sensor'.$id.'-back-btn">Retour</button>
                <button onclick="close_alert('.$id.')">Fermer</button>
            </section>
            <!-- État, titre et diagramme -->
            <section class="col col-xxl-7 p-0">
                <!-- État et titre -->
                <h2 class="sensor-title">
                    <!-- Description de l\'état du capteur -->
                    <i class="sensor-state" id="sensor'.$id.'-state">Actif</i>
                    <canvas class="sensor-dot" id="sensor'.$id.'-dot"></canvas>
                    &nbsp; Capteur <span id="sensor'.$id.'-title"></span>
                </h2>
                <!-- Diagramme du capteur -->
                <article class="pt-2 charts w-100">
                    <canvas id="sensor'.$id.'-charts"></canvas>
                </article>
            </section>
            <!-- Informations supplémentaires -->
            <section class="col-xxl ml-n4 separator row">
                <!-- Température actuelle -->
                <article class="col-xs row mb-3 mb-xxl-0">
                    <!-- Titre et description -->
                    <section class="col align-self-center">
                        <h3>Maintenant</h3>
                        <p>Température actuelle</p>
                    </section>
                    <!-- Valeur -->
                    <p class="col-1 align-self-center sensor-info" id="sensor'.$id.'-now"></p>
                </article>
                <!-- Température maximale -->
                <article class="col-xs row mb-3 mb-xxl-0">
                    <!-- Titre et description -->
                    <section class="col align-self-center">
                        <h3>Maximale</h3>
                        <p>Température maximale enregistrée</p>
                    </section>
                    <!-- Valeur -->
                    <p class="col-1 align-self-center sensor-info" id="sensor'.$id.'-max"></p>
                </article>
                <!-- Température minimale -->
                <article class="col-xs row">
                    <!-- Titre et description -->
                    <section class="col align-self-center">
                        <h3>Minimale</h3>
                        <p>Température minimale enregistrée</p>
                    </section>
                    <!-- Valeur -->
                    <p class="col-1 align-self-center sensor-info" id="sensor'.$id.'-min"></p>
                </article>
            </section>
        </article>';
    }

    for ($i = 0; $i < SENSORS_NUMBER; $i++) {
        if ($i % 2 == 0) {
            echo '<!-- Boite des capteurs -->
                    <section class="row">';
            box($i);
        } else {
            box($i);
            echo '</section>';
        }
    }
    ?>

    <!-- Comparaison des 2 capteurs -->
    <article class="m-1 box">
        <!-- Titre -->
        <h2 class="comparison-title">Graphique comparatif</h2>
        <!-- Diagramme de comparaison -->
        <article class="comparison-chart w-100">
            <canvas class="pt-2" id="comparison"></canvas>
        </article>
    </article>
</main>
<script>
    const sensors_data = <?= SENSORS_DATA ?>;
    const sensors_alert = <?= SENSORS_ALERTS ?>;
    const sensors_sync_time = <?= SENSORS_SYNC_TIME ?>;
    const sensors_comparison_data = <?= $_SESSION['nb_values_comparison'] ??= SENSORS_DEFAULT_NB_VALUE_COMPARISON ?>;
    const value_sensors = <?= $_SESSION['nb_values_sensors'] ??= SENSORS_DEFAULT_NB_VALUE ?>;
    console.log(sensors_comparison_data)
</script>
