<main class="container-fluid">
    <!-- Titre général pour l'accessibilité -->
    <h1 id="accessibility">Page d'inscription.</h1>
    <!-- Inscription -->
    <section class="box w-sm">
        <!-- Titre et redirection vers connexion -->
        <h2 class="box-title text-center">Inscription</h2>
        <p class="box-subtitle">Vous avez un compte ?
            <br>
            <a href="<?= ROOT ?>login">Se connecter</a>
        </p>
        <!-- Formulaire -->
        <form id="signUp_form" action="<?= ROOT ?>register" method="post">
            <hr>
            <!-- Google -->
            <section class="d-flex justify-content-center g-signin2" data-height="40" data-width="500" data-onsuccess="onSignIn" data-theme="dark"></section>
            <hr>
            <input type="hidden" name="anti_bot">
            <!-- Prénom -->
            <label for="first_name">Prénom</label>
            <input class="form-control" type="text" name="first_name" id="first_name" placeholder="Jean" maxlength="30" autofocus required autocomplete="name">
            <!-- Nom -->
            <label for="last_name">Nom</label>
            <input class="form-control" type="text" name="last_name" id="last_name" placeholder="Dupont" maxlength="30" required autocomplete="family-name">
            <!-- Email -->
            <label for="email">Email</label>
            <input class="form-control" type="email" name="email" id="email" placeholder="exemple@exemple.com" maxlength="50" required autocomplete="email">
            <!-- Mot de passe -->
            <label for="password">Mot de passe</label>
            <input class="form-control" type="password" name="password" id="password" placeholder="••••••••••••••" maxlength="99" required autocomplete="new-password">
            <!-- Vérification du mot de passe -->
            <label for="password_verify">Vérification du mot de passe</label>
            <input class="form-control mb-3" type="password" name="password_verify" id="password_verify" placeholder="••••••••••••••" maxlength="99" required autocomplete="new-password">
            <!-- Acceptation des mentions légales -->
            <label class="form-check-label" for="cgu_check">
                <input class="form-check-input" type="checkbox" name="cgu_check" id="cgu_check" required>
                En cochant cette case, vous acceptez nos <a href="<?= ROOT ?>cgu">Conditions Générales d'Utilisation</a> et avez prit connaissances des <a href="<?= ROOT ?>mentions-legales">Mentions Légales</a>.
            </label>
            <hr>
            <!-- Bouton de validation -->
            <button id="signUp" type="submit">Inscription</button>
        </form>
    </section>
</main>