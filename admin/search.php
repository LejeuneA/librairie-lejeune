<?php

require_once __DIR__ . '/settings.php';

$query = trim(
    (string) ($_GET['query'] ?? '')
);

$results = [];
$msg = null;
$searchExecuted = false;

/*
|--------------------------------------------------------------------------
| Validate search query
|--------------------------------------------------------------------------
*/

if ($query === '') {
    $msg = getMessage(
        'Veuillez saisir un terme de recherche.',
        'error'
    );
} elseif (mb_strlen($query) > 100) {
    $msg = getMessage(
        'Le terme de recherche est trop long.',
        'error'
    );
} elseif (!$conn instanceof PDO) {
    http_response_code(500);

    $msg = getMessage(
        'La recherche est temporairement indisponible.',
        'error'
    );
} else {
    $searchExecuted = true;

    try {
        /*
         * Her tablo için ayrı placeholder kullanıyoruz.
         * Yalnızca yayında olan ürünler gösterilir.
         */

        $sql = '
            SELECT
                "Livre" AS product_type,
                idLivre AS product_id,
                title,
                writer,
                feature,
                image_url
            FROM livres
            WHERE active = 1
                AND title LIKE :query_livre

            UNION ALL

            SELECT
                "Papeterie" AS product_type,
                idPapeterie AS product_id,
                title,
                NULL AS writer,
                feature,
                image_url
            FROM papeteries
            WHERE active = 1
                AND title LIKE :query_papeterie

            UNION ALL

            SELECT
                "Cadeau" AS product_type,
                idCadeau AS product_id,
                title,
                NULL AS writer,
                feature,
                image_url
            FROM cadeaux
            WHERE active = 1
                AND title LIKE :query_cadeau

            ORDER BY title ASC
            LIMIT 60
        ';

        $statement = $conn->prepare($sql);

        $searchValue = '%' . $query . '%';

        $statement->execute([
            'query_livre' => $searchValue,
            'query_papeterie' => $searchValue,
            'query_cadeau' => $searchValue,
        ]);

        $results = $statement->fetchAll(
            PDO::FETCH_ASSOC
        );
    } catch (PDOException $exception) {
        error_log(
            'Library search error: '
                . $exception->getMessage()
        );

        http_response_code(500);

        $results = [];

        $msg = getMessage(
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
    displayHeadSection('Résultats de recherche');
    displayJSSection();
    ?>
</head>

<body>

    <header>
        <div data-include="navigation"></div>
    </header>

    <main class="search-container container">

        <h1>Résultats de recherche</h1>

        <?php if ($msg !== null): ?>
            <div id="message">
                <?= $msg ?>
            </div>
        <?php endif; ?>

        <?php if (
            $searchExecuted
            && $msg === null
        ): ?>
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

                            $productUrl = '';

                            if ($productType === 'Livre') {
                                $productUrl =
                                    '../public/product-livre.php?idLivre='
                                    . $productId;
                            } elseif (
                                $productType === 'Papeterie'
                            ) {
                                $productUrl =
                                    '../public/product-papeterie.php?idPapeterie='
                                    . $productId;
                            } elseif (
                                $productType === 'Cadeau'
                            ) {
                                $productUrl =
                                    '../public/product-cadeau.php?idCadeau='
                                    . $productId;
                            }

                            $title = (string) (
                                $row['title'] ?? ''
                            );

                            $writer = (string) (
                                $row['writer'] ?? ''
                            );

                            $feature = (string) (
                                $row['feature'] ?? ''
                            );

                            $imageUrl = trim(
                                (string) (
                                    $row['image_url'] ?? ''
                                )
                            );

                            if (
                                preg_match(
                                    '#^\s*(javascript|data):#i',
                                    $imageUrl
                                )
                            ) {
                                $imageUrl = '';
                            }
                            ?>

                            <li>

                                <?php if (
                                    $productUrl !== ''
                                ): ?>
                                    <a
                                        href="<?= escapeHtml(
                                                    $productUrl
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
                                                        ) ?>">
                                        <?php endif; ?>
                                    </a>
                                <?php endif; ?>

                                <p class="type">
                                    <?= escapeHtml(
                                        $productType
                                    ) ?>
                                </p>

                                <h2>
                                    <?= escapeHtml(
                                        $title
                                    ) ?>
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
