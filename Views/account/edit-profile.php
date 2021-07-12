<main class="container-lg">
    <!-- Titre général pour l'accessibilité -->
    <h1 id="accessibility">Page d'édition des informations du compte.</h1>
    <!-- Boite principale -->
    <section class="w-lg box">
        <form class="p-0" action="<?= ROOT ?>account/edit" method="post" enctype="multipart/form-data">
            <!-- Titre -->
            <h2 class="box-title">Votre profil</h2>
            <hr>
            <article class="row">
                <section class="col-sm-4 col-md-3 col-lg-2 mb-3 mb-sm-0 align-self-center d-flex justify-content-center">
                    <li id="change-img">
                        <img id="profil-picture" src="<?= $_SESSION['avatar'] ?>" alt="Image de profil du compte.">
                        <label for="profilImage">&#10010;</label>
                        <input accept="image/*" type="file" name="file" id="profilImage" onchange="showMyImage(this)">
                    </li>
                </section>
                <section class="col col-md-9 col-lg-10">
                        <!-- Email -->
                        <label for="email">Email</label>
                        <input class="form-control" type="email" name="email" id="email" placeholder="exemple@exemple.com" maxlength="50" value="<?= $_SESSION['email'] ?>" required autocomplete="email">
                        <!-- Prénom -->
                        <label for="first_name">Prénom</label>
                        <input class="form-control" type="text" name="first_name" id="first_name" placeholder="Jean" maxlength="30" value="<?= $_SESSION['first_name'] ?>" required autocomplete="name">
                        <!-- Nom -->
                        <label for="last_name">Nom</label>
                        <input class="form-control" type="text" name="last_name" id="last_name" placeholder="Dupont" maxlength="30" value="<?= $_SESSION['last_name'] ?>" required autocomplete="family-name">
                </section>
            </article>
            <hr>
            <button name="update" type="submit">Modifier</button>
            <!-- On vérifie s'il n'est pas connecté avec un compte Google ou Facebook -->
            <?php if (is_null($_SESSION['id_google']) && is_null($_SESSION['id_facebook'])): ?>
                <button type="button" onclick="show(-1)">Modifier le mot de passe</button>
            <?php endif; ?>
            <a class="button m-0 m-top" href="<?= ROOT ?>account">Retour</a>
        </form>
    </section>
    <!-- On vérifie s'il n'est pas connecté avec un compte Google ou Facebook -->
    <?php if (is_null($_SESSION['id_google']) && is_null($_SESSION['id_facebook'])): ?>
        <article class="overlay" id="overlay">
            <section class="box w-md">
                <!-- Titre -->
                <h2 class="box-title text-center">Modification du mot de passe</h2>
                <!-- Formulaire -->
                <form action="<?= ROOT ?>account/edit" method="post">
                    <hr>
                    <!-- Ancien mot de passe -->
                    <label for="old_password">Ancien mot de passe</label>
                    <input class="form-control" type="password" name="old_password" id="old_password" placeholder="••••••••••••••••••••" maxlength="99" required autocomplete="current-password">
                    <!-- Nouveau mot de passe -->
                    <label for="new_password">Nouveau mot de passe</label>
                    <input class="form-control" type="password" name="new_password" id="new_password" placeholder="••••••••••••••" maxlength="99" required autocomplete="new-password">
                    <!-- Confirmation du nouveau mot de passe -->
                    <label for="new_password_verify">Confirmation du nouveau mot de passe</label>
                    <input class="form-control" type="password" name="new_password_verify" id="new_password_verify" placeholder="••••••••••••••" maxlength="99" required autocomplete="new-password">
                    <hr>
                    <!-- Valider -->
                    <button type="submit" name="password_update">Valider</button>
                    <button type="button" onclick="hide(-1)">Fermer</button>
                </form>
            </section>
        </article>
    <?php endif; ?>
</main>