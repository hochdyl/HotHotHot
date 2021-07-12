<main class="container-lg">
    <!-- Titre général pour l'accessibilité -->
    <h1 id="accessibility">Page de profil du compte.</h1>
    <!-- Boite principale -->
    <section class="w-lg box">
        <!-- Titre -->
        <h2 class="box-title">Votre profil</h2>
        <hr>
        <article class="row">
            <section class="col-sm-4 col-md-3 col-lg-2 mb-3 mb-sm-0 align-self-center d-flex justify-content-center">
                <img id="profil-picture" src="<?= $_SESSION['avatar'] ?>" alt="Image de profil du compte.">
            </section>
            <section class="col-8 col-md-9 col-lg-10 row">
                <section class="col-sm-6">
                    <div>
                        <h2>Prénom :</h2>
                        <p><?= $_SESSION['first_name'] ?></p>
                    </div>
                    <div>
                        <h2>Nom :</h2>
                        <p><?= $_SESSION['last_name'] ?></p>
                    </div>
                </section>
                <section class="col-sm-6 mt-3 mt-sm-0">
                    <div>
                        <h2>Email :</h2>
                        <p><?= $_SESSION['email'] ?></p>
                    </div>
                    <div>
                        <h2>Date de création :</h2>
                        <p>Le <?= date("d-m-Y à H:i:s", strtotime($_SESSION['created_at'])) ?></p>
                    </div>
                </section>
            </section>
        </article>
        <hr>
        <a class="button" href="<?= ROOT ?>account/edit">Modifier</a>
        <a class="button m-0" href="#" onclick="show(-1)">Supprimer le compte</a>
    </section>
    <article class="overlay" id="overlay">
        <section class="box w-sm">
            <!-- Titre -->
            <h2 class="box-title text-center">Voulez-vous vraiment supprimer votre compte ?</h2>
            <p class="text-center box-subtitle">Écrivez "delete <?= $_SESSION['email'] ?>" pour confirmez</p>
            <!-- Formulaire -->
            <form action="<?= ROOT ?>account" method="post">
                <hr>
                <label for="delete_confirm" hidden>Suppression du compte</label>
                <input class="form-control text-dark" type="text" name="delete_confirm" id="delete_confirm" required>
                <hr>
                <!-- Boutons de choix -->
                <button type="submit" name="delete">Confirmer la suppression</button>
                <a class="button m-0" href="#" onclick="hide(-1)">Retour</a>
            </form>
        </section>
    </article>
</main>