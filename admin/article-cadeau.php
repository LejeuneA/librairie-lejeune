<?php

require_once __DIR__ . '/settings.php';

requireLogin();

$msg = null;
$result = null;
$execute = false;
$pageTitle = 'Cadeau';

/*
|--------------------------------------------------------------------------
| Validate gift ID
|--------------------------------------------------------------------------
*/

$idCadeau = filter_input(
    INPUT_GET,
    'idCadeau',
    FILTER_VALIDATE_INT,
    [
        'options' => [
            'min_range' => 1,
        ],
    ]
);

if ($idCadeau === false || $idCadeau === null) {
    http_response_code(404);

    $msg = getMessage(
        'Le cadeau demandé est introuvable.',
        'error'
    );
} elseif (!$conn instanceof PDO) {
    http_response_code(500);

    $msg = getMessage(
        'La connexion à la base de données est indisponible.',
        'error'
    );
} else {
    /*
    |--------------------------------------------------------------------------
    | Retrieve gift
    |--------------------------------------------------------------------------
    */

    $result = getCadeauByIDDB(
        $conn,
        $idCadeau
    );

    if (
        is_array($result)
        && !isset($result['error'])
        && !empty($result)
    ) {
        $execute = true;

        $productTitle = trim(
            strip_tags(
                (string) ($result['title'] ?? '')
            )
        );

        if ($productTitle !== '') {
            $pageTitle = mb_substr(
                $productTitle,
                0,
                120
            );
        }
    } else {
        http_response_code(404);

        $msg = getMessage(
            'Le cadeau demandé est introuvable.',
            'error'
        );
    }
}

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <?php displayHeadSection($pageTitle); ?>
</head>

<body>

    <header>
        <?php displayNavigation(); ?>
    </header>

    <main>
        <div class="container">

            <div id="message">
                <?= $msg ?? '' ?>
            </div>

            <div id="content">
                <?php if ($execute): ?>
                    <?php displayCadeauByID($result); ?>
                <?php endif; ?>
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
