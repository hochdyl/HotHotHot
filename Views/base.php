<!doctype html>
<html lang="fr">
<head>
    <!-- Meta pour l'encodage et l'affichage mobile -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <?php if ($_SERVER['REQUEST_URI'] === ROOT . 'register' || $_SERVER['REQUEST_URI'] === ROOT . 'login'): ?>
        <meta name="google-signin-client_id" content="85563966196-f61n6rna4a9dm6f2o3unk9cqa4agu1s1.apps.googleusercontent.com">
        <script async defer crossorigin="anonymous" src="https://connect.facebook.net/fr_FR/sdk.js#xfbml=1&version=v9.0&appId=803591893562929&autoLogAppEvents=1" nonce="FqbH8LPh"></script>
    <?php endif; ?>

    <!-- Titre de la page -->
    <title><?= $title ??= 'Projet' ?> | Hothothot</title>

    <!-- CSS -->
    <link rel="icon" href="<?= SCRIPTS . 'images/favicon.ico' ?>">
    <link rel="stylesheet" href="<?= SCRIPTS . 'css/wbbtheme.css' ?>">
    <link rel="stylesheet" href="<?= SCRIPTS . 'css/bootstrap/bootstrap.min.css' ?>">
    <link rel="stylesheet" href="<?= SCRIPTS . 'css/style.css' ?>">
</head>

<body>
<!-- Haut de page -->
<header>
    <nav class="navbar navbar-expand-sm navbar-dark">
        <section class="container-xl">
            <a class="navbar-brand" href="<?= ROOT ?>">
                <img src="<?= SCRIPTS . 'images/logo.png' ?>" alt="Logo Hothothot.">
            </a>
            <button class="navbar-toggler collapsed" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbar" aria-controls="navbar" aria-expanded="false">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="navbar-collapse collapse" id="navbar">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <hr class="mt-3 d-block d-sm-none">
                        <a class="nav-link" href="<?= ROOT ?>">Accueil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= ROOT ?>settings">Paramétrages</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link" id="dropdown1" href="" data-bs-toggle="dropdown"
                           aria-expanded="false">
                            Documentation
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="dropdown1">
                            <li>
                                <a class="dropdown-item" href="<?= ROOT ?>help">Notice utilisateur</a>
                            </li>
                            <?php if (isAuthenticated()): ?>
                            <li>
                                <a class="dropdown-item" href="<?= ROOT ?>help/framework">Framework</a>
                            </li>
                            <?php endif; ?>
                            <li>
                                <a class="dropdown-item" href="<?= ROOT ?>help/edition">Édition</a>
                            </li>
                            <?php if (isAuthenticated()): ?>
                            <li>
                                <a class="dropdown-item" href="<?= ROOT ?>help/editor">Éditeur</a>
                            </li>
                            <?php endif; ?>
                        </ul>
                    </li>
                    <li class="nav-item dropdown d-block d-sm-none">
                        <hr class="mt-3">
                        <?php if (isAuthenticated()): ?>
                            <a class="nav-link" id="dropdown2" href="" data-bs-toggle="dropdown"
                               aria-expanded="false">
                                <?= "{$_SESSION['first_name']}&nbsp;{$_SESSION['last_name']}" ?>
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="dropdown2">
                                <li>
                                    <a class="dropdown-item" href="<?= ROOT ?>account">Compte</a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="<?= ROOT ?>logout">Se déconnecter</a>
                                </li>
                            </ul>
                        <?php else: ?>
                            <a class="nav-link" id="dropdown2" href="" data-bs-toggle="dropdown"
                               aria-expanded="false">Compte</a>
                            <ul class="dropdown-menu" aria-labelledby="dropdown2">
                                <li>
                                    <a class="dropdown-item" href="<?= ROOT ?>login">Se connecter</a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="<?= ROOT ?>register">S'inscrire</a>
                                </li>
                            </ul>
                        <?php endif; ?>
                    </li>
                </ul>
                <section class="nav-item dropdown d-none d-sm-block">
                    <?php if (isAuthenticated()): ?>
                        <a class="nav-link" id="dropdown3" href="" data-bs-toggle="dropdown" aria-expanded="false">
                            <?= "{$_SESSION['first_name']}&nbsp;{$_SESSION['last_name']}" ?>
                            <img src="<?= $_SESSION['avatar'] ?>" alt="Profil picture.">
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="dropdown3">
                            <li>
                                <a class="dropdown-item" href="<?= ROOT ?>account">Mon profil</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="<?= ROOT ?>logout">Se déconnecter</a>
                            </li>
                        </ul>
                    <?php else: ?>
                        <a class="nav-link" id="dropdown3" href="" data-bs-toggle="dropdown" aria-expanded="false">
                            Compte
                            <img src="<?= SCRIPTS . 'images/profil-picture.png' ?>" alt="Profil picture.">
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="dropdown3">
                            <li>
                                <a class="dropdown-item" href="<?= ROOT ?>login">Se connecter</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="<?= ROOT ?>register">S'inscrire</a>
                            </li>
                        </ul>
                    <?php endif; ?>
                </section>
            </div>
        </section>
    </nav>
</header>

<!-- Contenu principal -->
<?= $content ??= null ?>

<!-- Bas de page -->
<footer>
    <section class="container">
        <p>
            &copy; <?= date("Y"); ?>
            <a href="<?= ROOT ?>">Hothothot.fr</a> &nbsp;|&nbsp; <a href="<?= ROOT ?>mentions-legales">Mentions Légales</a>
        <p>
    </section>
</footer>

<!-- Scripts pour les diagrammes et alertes -->
<?= addJavaScript('js/account/utilities.js') ?>
<?= addJavaScript('js/bootstrap/bootstrap.min.js') ?>
<!-- Graphique page d'accueil -->
<?= addJavaScript('js/jquery/jquery-3.5.1.min.js','') ?>
<?= addJavaScript('js/chart/Chart.bundle.min.js','') ?>
<?= addJavaScript('js/home/Diagrammes.js','') ?>
<?= addJavaScript('js/home/Alertes.js','') ?>
<!-- Google -->
<?= addJavaScript('js/account/register.js','register') ?>
<?= addJavaScript('js/account/login.js','login') ?>
<!-- Ajax pour la page de settings -->
<?= addJavaScript('js/setting/setting.js','settings') ?>
<!-- Google -->
<?= addJavaScript('https://apis.google.com/js/platform.js', 'register') ?>
<?= addJavaScript('https://apis.google.com/js/platform.js', 'login') ?>
<!-- Editeur Wisiwig -->
<?= addJavaScript('https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js') ?>
<?= addJavaScript('https://cdn.wysibb.com/js/jquery.wysibb.min.js') ?>
<script>
    $(function() {
        $("#editor").wysibb();
    })
</script>
</body>
</html>
