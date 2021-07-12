<main class="container-md">
    <!-- Titre général pour l'accessibilité -->
    <h1 id="accessibility">Zone de texte pour les commentaires.</h1>
    <!-- Editeur Wisiwig -->
    <section class="box">
        <!-- Titre -->
        <h2 class="box-title">Éditeur</h2>
        <hr>
        <form class="p-0" method="post" action="">
            <!-- ID -->
            <?php if (!empty($editor['id'])): ?>
            <label for="id" hidden>ID :</label>
            <input class="form-control" type="number" name="id" id="id" placeholder="ID" value="<?= $editor['id'] ??= '' ?>" required hidden>
            <?php endif; ?>
            <!-- Titre -->
            <label for="title">Titre :</label>
            <input class="form-control" type="text" name="title" id="title" placeholder="Titre" maxlength="50" value="<?= $editor['title'] ??= '' ?>" required autocomplete>
            <!-- Contenu -->
            <label for="documentation">Contenu :</label>
            <textarea name="documentation" id="editor"><?= $editor['content_raw'] ??= '' ?></textarea>
            <!-- Validation -->
            <button class="m-top" type="submit">Valider</button>
        </form>
    </section>
</main>