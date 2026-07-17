<?php

require_once __DIR__ . '/settings.php';

/*
|--------------------------------------------------------------------------
| Search state
|--------------------------------------------------------------------------
*/

$query = trim(
    (string) ($_GET['query'] ?? '')
);

$results = [];
$message = null;
$searchExecuted = false;

/*
|--------------------------------------------------------------------------
| Validate search query
|--------------------------------------------------------------------------
*/

if ($query === '') {
    $message = getMessage(
        'Veuillez saisir un terme de recherche.',
        'error'
    );
} elseif (mb_strlen($query) > 100) {
    $message = getMessage(
        'Le terme de recherche est trop long.',
        'error'
    );
} elseif (!$conn instanceof PDO) {
    http_response_code(500);

    $message = getMessage(
        'La recherche est temporairement indisponible.',
        'error'
    );
} else {
    $searchExecuted = true;

    /*
    |--------------------------------------------------------------------------
    | Search published products
    |--------------------------------------------------------------------------
    */

    try {
        $sql = "
            SELECT
                'Livre' AS product_type,
                idLivre AS product_id,
                title,
                writer,
                feature,
                image_url
            FROM livres
            WHERE active = 1
                AND (
                    title LIKE :livre_title
                    OR writer LIKE :livre_writer
                    OR feature LIKE :livre_feature
                )

            UNION ALL

            SELECT
                'Papeterie' AS product_type,
                idPapeterie AS product_id,
                title,
                NULL AS writer,
                feature,
                image_url
            FROM papeteries
            WHERE active = 1
                AND (
                    title LIKE :papeterie_title
                    OR feature LIKE :papeterie_feature
                )

            UNION ALL

            SELECT
                'Cadeau' AS product_type,
                idCadeau AS product_id,
                title,
                NULL AS writer,
                feature,
                image_url
            FROM cadeaux
            WHERE active = 1
                AND (
                    title LIKE :cadeau_title
                    OR feature LIKE :cadeau_feature
                )

            ORDER BY title ASC
            LIMIT 60
        ";

        $statement = $conn->prepare($sql);

        $searchValue = '%' . $query . '%';

        $statement->execute([
            'livre_title' => $searchValue,
            'livre_writer' => $searchValue,
            'livre_feature' => $searchValue,

            'papeterie_title' => $searchValue,
            'papeterie_feature' => $searchValue,

            'cadeau_title' => $searchValue,
            'cadeau_feature' => $searchValue,
        ]);

        $results = $statement->fetchAll(
            PDO::FETCH_ASSOC
        );
    } catch (Throwable $exception) {
        error_log(
            'Library search error: '
                . $exception->getMessage()
        );

        http_response_code(500);

        $results = [];

        $message = getMessage(
            'Une erreur est survenue pendant la recherche.',
            'error'
        );
    }
}

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <?php
    displayHeadSection(
        'Résultats de recherche'
    );
    ?>
</head>

<body>

    <header>
        <div data-include="navigation"></div>
    </header>

    <main class="search-container container">

        <h1>Résultats de recherche</h1>

        <?php if ($message !== null): ?>

            <div id="message">
                <?= $message ?>
            </div>

        <?php elseif ($searchExecuted): ?>

            <p class="search-results-count">
                Résultats trouvés :
                <?= count($results) ?>
            </p>

            <?php if (!empty($results)): ?>

                <div class="search-results">
                    <ul>

                        <?php foreach ($results as $row): ?>

                            <?php

                            $productType = (string) (
                                $row['product_type'] ?? ''
                            );

                            $productId = (int) (
                                $row['product_id'] ?? 0
                            );

                            /*
                            |--------------------------------------------------------------------------
                            | Decode stored HTML entities
                            |--------------------------------------------------------------------------
                            */

                            $title = html_entity_decode(
                                (string) (
                                    $row['title'] ?? ''
                                ),
                                ENT_QUOTES | ENT_HTML5,
                                'UTF-8'
                            );

                            $writer = html_entity_decode(
                                (string) (
                                    $row['writer'] ?? ''
                                ),
                                ENT_QUOTES | ENT_HTML5,
                                'UTF-8'
                            );

                            $feature = html_entity_decode(
                                (string) (
                                    $row['feature'] ?? ''
                                ),
                                ENT_QUOTES | ENT_HTML5,
                                'UTF-8'
                            );

                            /*
                            |--------------------------------------------------------------------------
                            | Build safe public product URL
                            |--------------------------------------------------------------------------
                            */

                            $productUrl = '';

                            switch ($productType) {
                                case 'Livre':
                                    $productUrl =
                                        rtrim(DOMAIN, '/')
                                        . '/public/product-livre.php?idLivre='
                                        . $productId;

                                    break;

                                case 'Papeterie':
                                    $productUrl =
                                        rtrim(DOMAIN, '/')
                                        . '/public/product-papeterie.php?idPapeterie='
                                        . $productId;

                                    break;

                                case 'Cadeau':
                                    $productUrl =
                                        rtrim(DOMAIN, '/')
                                        . '/public/product-cadeau.php?idCadeau='
                                        . $productId;

                                    break;
                            }

                            /*
                            |--------------------------------------------------------------------------
                            | Build absolute image URL
                            |--------------------------------------------------------------------------
                            |
                            | Veritabanındaki "uploads/image.jpg" yolu:
                            |
                            | Local:
                            | http://localhost/.../uploads/image.jpg
                            |
                            | Production:
                            | https://library.acelyalejeune.com/uploads/image.jpg
                            |
                            */

                            $imageUrl = safeAssetUrl(
                                $row['image_url'] ?? ''
                            );

                            ?>

                            <?php if (
                                $productId > 0
                                && $productUrl !== ''
                            ): ?>

                                <li>

                                    <a
                                        href="<?= escapeHtml(
                                                    $productUrl
                                                ) ?>"
                                        aria-label="<?= escapeHtml(
                                                        'Voir '
                                                            . $title
                                                    ) ?>">
                                        <?php if (
                                            $imageUrl !== ''
                                        ): ?>

                                            <img
                                                src="<?= escapeHtml(
                                                            $imageUrl
                                                        ) ?>"
                                                alt="<?= escapeHtml(
                                                            'Image de '
                                                                . $title
                                                        ) ?>"
                                                loading="lazy">

                                        <?php endif; ?>
                                    </a>

                                    <p class="type">
                                        <?= escapeHtml(
                                            $productType
                                        ) ?>
                                    </p>

                                    <h2>
                                        <a
                                            href="<?= escapeHtml(
                                                        $productUrl
                                                    ) ?>">
                                            <?= escapeHtml(
                                                $title
                                            ) ?>
                                        </a>
                                    </h2>

                                    <?php if (
                                        $writer !== ''
                                    ): ?>

                                        <p class="writer">
                                            <?= escapeHtml(
                                                $writer
                                            ) ?>
                                        </p>

                                    <?php endif; ?>

                                    <?php if (
                                        $feature !== ''
                                    ): ?>

                                        <p class="feature">
                                            <?= escapeHtml(
                                                $feature
                                            ) ?>
                                        </p>

                                    <?php endif; ?>

                                </li>

                            <?php endif; ?>

                        <?php endforeach; ?>

                    </ul>
                </div>

            <?php else: ?>

                <p>
                    Aucun résultat trouvé pour
                    « <?= escapeHtml($query) ?> ».
                </p>

            <?php endif; ?>

        <?php endif; ?>

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
