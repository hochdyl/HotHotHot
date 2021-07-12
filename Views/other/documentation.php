<main class="container-md">
    <!-- Titre général pour l'accessibilité -->
    <h1 id="accessibility">Page de documentation.</h1>
    <!-- Documentation -->
    <section class="box mb-3">
        <!-- Titre -->
        <section class="row">
            <h2 class="col box-title m-0"><?= $documentation['title'] ?></h2>
            <?php if (!empty($_SESSION['role_id']) && $_SESSION['role_id'] === 1): ?>
            <a class="col-1 d-flex align-items-center justify-content-end" href="<?= ROOT ?>help/editor?page=<?= $documentation['page'] ?>">
                <img src="<?= SCRIPTS . 'images/edit.png' ?>" alt="Bouton de téléchargement des données du capteur.">
            </a>
            <?php endif; ?>
        </section>
        <?php if (!empty($_SESSION['role_id']) && $_SESSION['role_id'] === 1): ?>
        <p class="box-subtitle text-left">Édité par <?= $documentation['username'] ?> le <?= date("d-m-Y à H:i:s", strtotime($documentation['updated_at'])) ?> </p>
        <?php endif; ?>
        <hr>
        <?= $documentation['content'] ?>
    </section>
</main>