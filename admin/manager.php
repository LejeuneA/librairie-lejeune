<?php

require_once __DIR__ . '/settings.php';

requireLogin();

$userEmail = escapeHtml(
    $_SESSION['user_email'] ?? '',
);

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <?php
    displayHeadSection('Gestion des produits');
    displayJSSection();
    ?>
</head>

<body>

    <header class="manager-header">
        <?php displayNavigation(); ?>
    </header>

    <main class="manager-container">

        <div class="welcome">
            <div class="welcome-text">
                Bienvenue
                <span><?= $userEmail ?></span>
            </div>
        </div>

        <div class="manager-content container">

            <h1 class="title">
                Gérer les produits
            </h1>

            <?php if (isGuest()): ?>
                <div class="message">
                    <?= getMessage(
                        'Compte de démonstration : vous pouvez parcourir toutes les pages de gestion, mais l’ajout, la modification et la suppression sont désactivés.',
                        'success',
                    ) ?>
                </div>
            <?php endif; ?>

            <?php if (isset($_GET['readonly'])): ?>
                <div class="message">
                    <?= getMessage(
                        'Cette opération est désactivée pour le compte de démonstration.',
                        'error',
                    ) ?>
                </div>
            <?php endif; ?>

            <div class="category-container">

                <!-- Livres -->
                <div class="category-card">
                    <a
                        class="btn-primary"
                        href="manager-livre.php">
                        Gérer les livres
                    </a>

                    <a
                        class="btn-primary"
                        href="add-livre.php">
                        Ajouter un livre
                    </a>
                </div>

                <!-- Papeteries -->
                <div class="category-card">
                    <a
                        class="btn-primary"
                        href="manager-papeterie.php">
                        Gérer les papeteries
                    </a>

                    <a
                        class="btn-primary"
                        href="add-papeterie.php">
                        Ajouter une papeterie
                    </a>
                </div>

                <!-- Cadeaux -->
                <div class="category-card">
                    <a
                        class="btn-primary"
                        href="manager-cadeau.php">
                        Gérer les cadeaux
                    </a>

                    <a
                        class="btn-primary"
                        href="add-cadeau.php">
                        Ajouter un cadeau
                    </a>
                </div>

                <div class="background-vector">
                    <img
                        src="../assets/components/background-vector.png"
                        alt="">
                </div>

            </div>

        </div>

    </main>

    <footer>
        <?php displayFooter(); ?>
    </footer>

    <script
        src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/js/all.min.js"
        integrity="sha512-u3fPA7V8qQmhBPNT5quvaXVa1mnnLSXUep5PS1qo5NRzHwG19aHmNJnj1Q8hpA/nBWZtZD4r4AX6YOt5ynLN2g=="
        crossorigin="anonymous"
        referrerpolicy="no-referrer"></script>

    <script src="../js/functions.js"></script>

</body>

</html>
