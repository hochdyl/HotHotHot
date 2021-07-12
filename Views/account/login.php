<main class="container-fluid">
    <!-- Titre général pour l'accessibilité -->
    <h1 id="accessibility">Page de connexion.</h1>
    <!-- Connexion -->
    <section class="box w-sm">
        <!-- Titre et redirection vers inscription -->
        <h2 class="box-title text-center">Connexion</h2>
        <p class="box-subtitle">Vous n'avez pas de compte ?
            <br>
            <a href="<?= ROOT ?>register">Créer un compte</a>
        </p>
        <!-- Formulaire -->
        <form id="login_form" action="<?= ROOT ?>login" method="post">
            <hr>
            <!-- Google -->
            <section class="d-flex justify-content-center g-signin2" data-height="40" data-width="500" data-onsuccess="onSignIn" data-theme="dark"></section>
            <hr>
            <!-- Email -->
            <label for="email">Email</label>
            <input class="form-control" type="email" name="email" id="email" placeholder="exemple@exemple.com" maxlength="50" autofocus required autocomplete="email">
            <!-- Mot de passe -->
            <label for="password">Mot de passe</label>
            <input class="form-control m-0" type="password" name="password" id="password" placeholder="••••••••••••••" maxlength="99" required autocomplete="current-password">
            <a id="oublie-mdp" href="#" onclick="show(-1)">Mot de passe oublié ?</a>
            <hr>
            <!-- Se connecter -->
            <button type="submit" id="login" name="login">Se connecter</button>
        </form>
        <article class="overlay" id="overlay">
            <section class="box w-md">
                <!-- Titre -->
                <h2 class="box-title text-center">Récupération du compte</h2>
                <!-- Formulaire -->
                <form action="<?= ROOT ?>login" method="post">
                    <hr>
                    <!-- Email -->
                    <label for="recovery-email">Email</label>
                    <input class="form-control" type="email" name="recovery-email" id="recovery-email" placeholder="exemple@exemple.com" maxlength="50" required autocomplete="email">
                    <hr>
                    <!-- Valider -->
                    <button type="submit">Valider</button>
                    <button type="button" onclick="hide(-1)">Fermer</button>
                </form>
            </section>
        </article>
    </section>
</main>
