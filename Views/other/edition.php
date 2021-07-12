<main class="container-md">
    <!-- Titre général pour l'accessibilité -->
    <h1 id="accessibility">Commentaires des utilisateurs.</h1>
    <?php if (!$documentations): ?>
        <section class="box">
            <!-- Titre -->
            <h2 class="box-title hr">Aucun message</h2>
            <p class="box-subtitle">Les utilisateurs n'ont pas encore posté de messages.</p>
            <hr>
            <a class="button" href="<?= ROOT ?>help/editor">Ajouter un message</a>
            <a class="button m-0" href="<?= ROOT ?>">Retour à l'accueil</a>
        </section>
    <?php else: ?>
        <?php foreach ($documentations as $documentation): ?>
            <section class="box mb-4">
                <!-- Titre -->
                <h2 class="box-title hr"><?= $documentation['title'] ?></h2>
                <p class="box-subtitle">Par <?= $documentation['username'] ?> le <?= date("d-m-Y à H:i:s", strtotime($documentation['date'])) ?>
                </p>
                <hr>
                <?php if ($documentation['user_id'] === $_SESSION['id'] || $_SESSION['role_id'] === 1): ?>
                <section class="d-flex bd-highlight">
                    <span class="flex-grow-1 m-0 me-2 bd-highlight"><?= $documentation['content'] ?></span>
                    <?php if ($documentation['user_id'] === $_SESSION['id']): ?>
                    <a class="p-0 bd-highlight me-2" href="<?= ROOT ?>help/editor?comment=<?= $documentation['id'] ?>"><img src="<?= SCRIPTS . 'images/edit.png' ?>" alt="Bouton de suppression du commentaire."></a>
                    <?php endif; ?>
                    <a class="p-0 bd-highlight" href="#" onclick="show(<?= $documentation['id'] ?>)"><img src="<?= SCRIPTS . 'images/delete.png' ?>" alt="Bouton de suppression du commentaire."></a>
                </section>
                <?php else: ?>
                    <?= $documentation['content'] ?>
                <?php endif; ?>
            </section>
            <article class="overlay center" id="overlay<?= $documentation['id'] ?>">
                <section class="box w-md">
                    <!-- Titre -->
                    <h2 class="box-title text-center">Suppression du message</h2>
                    <p class="box-subtitle text-center">Voulez vous vraiment supprimer le message "<?= $documentation['title'] ?>" ?</p>
                    <!-- Formulaire -->
                    <form action="<?= ROOT ?>help/edition" method="post">
                        <hr>
                        <input type="number" name="id" value="<?= $documentation['id'] ?>" required hidden>
                        <!-- Valider -->
                        <button type="submit" name="remove-edition">Supprimer</button>
                        <button type="button" onclick="hide(<?= $documentation['id'] ?>)">Retour</button>
                    </form>
                </section>
            </article>
        <?php endforeach; ?>
        <section class="container pe-2 px-2">
            <a class="button" href="<?= ROOT ?>help/editor">Ajouter un message</a>
            <a class="button m-0" href="<?= ROOT ?>">Retour à l'accueil</a>
        </section>
    <?php endif; ?>
</main>