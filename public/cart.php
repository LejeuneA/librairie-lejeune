<?php

require_once __DIR__
    . '/../admin/settings.php';

/*
|--------------------------------------------------------------------------
| Authentication
|--------------------------------------------------------------------------
*/

if (!isAuthenticated()) {
    header(
        'Location: '
            . rtrim(DOMAIN, '/')
            . '/admin/login.php'
    );

    exit();
}

/*
|--------------------------------------------------------------------------
| Cart initialization
|--------------------------------------------------------------------------
*/

if (
    !isset($_SESSION['cart'])
    || !is_array($_SESSION['cart'])
) {
    $_SESSION['cart'] = [];
}

/*
|--------------------------------------------------------------------------
| Only POST requests may change the cart
|--------------------------------------------------------------------------
*/

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header(
        'Location: '
            . rtrim(DOMAIN, '/')
            . '/public/cart-view.php'
    );

    exit();
}

/*
|--------------------------------------------------------------------------
| Validate requested action
|--------------------------------------------------------------------------
*/

if (($_POST['action'] ?? '') !== 'add') {
    $_SESSION['cart_message'] = getMessage(
        'L’action demandée est invalide.',
        'error'
    );

    header(
        'Location: '
            . rtrim(DOMAIN, '/')
            . '/public/cart-view.php'
    );

    exit();
}

/*
|--------------------------------------------------------------------------
| CSRF validation
|--------------------------------------------------------------------------
*/

$submittedToken = (string) (
    $_POST['csrf_token'] ?? ''
);

$sessionToken = (string) (
    $_SESSION['csrf_token'] ?? ''
);

if (
    $submittedToken === ''
    || $sessionToken === ''
    || !hash_equals(
        $sessionToken,
        $submittedToken
    )
) {
    $_SESSION['cart_message'] = getMessage(
        'Votre session a expiré. Veuillez réessayer.',
        'error'
    );

    header(
        'Location: '
            . rtrim(DOMAIN, '/')
            . '/public/cart-view.php'
    );

    exit();
}

/*
|--------------------------------------------------------------------------
| Validate product information
|--------------------------------------------------------------------------
*/

$productId = filter_input(
    INPUT_POST,
    'productId',
    FILTER_VALIDATE_INT,
    [
        'options' => [
            'min_range' => 1,
        ],
    ]
);

$productType = (string) (
    $_POST['productType'] ?? ''
);

$productSources = [
    'livre' => [
        'table' => 'livres',
        'id_column' => 'idLivre',
    ],

    'papeterie' => [
        'table' => 'papeteries',
        'id_column' => 'idPapeterie',
    ],

    'cadeau' => [
        'table' => 'cadeaux',
        'id_column' => 'idCadeau',
    ],
];

if (
    $productId === false
    || $productId === null
    || !isset($productSources[$productType])
) {
    $_SESSION['cart_message'] = getMessage(
        'Le produit sélectionné est invalide.',
        'error'
    );

    header(
        'Location: '
            . rtrim(DOMAIN, '/')
            . '/public/cart-view.php'
    );

    exit();
}

if (!$conn instanceof PDO) {
    $_SESSION['cart_message'] = getMessage(
        'Le panier est temporairement indisponible.',
        'error'
    );

    header(
        'Location: '
            . rtrim(DOMAIN, '/')
            . '/public/cart-view.php'
    );

    exit();
}

/*
|--------------------------------------------------------------------------
| Retrieve the published product
|--------------------------------------------------------------------------
*/

$productSource =
    $productSources[$productType];

$tableName =
    $productSource['table'];

$idColumn =
    $productSource['id_column'];

try {
    $statement = $conn->prepare(
        "
        SELECT
            {$idColumn} AS id,
            title,
            price,
            image_url,
            feature
        FROM {$tableName}
        WHERE {$idColumn} = :product_id
            AND active = 1
        LIMIT 1
        "
    );

    $statement->execute([
        'product_id' => $productId,
    ]);

    $product = $statement->fetch(
        PDO::FETCH_ASSOC
    );
} catch (PDOException $exception) {
    error_log(
        'Cart product query error: '
            . $exception->getMessage()
    );

    $product = false;
}

if (!is_array($product) || empty($product)) {
    $_SESSION['cart_message'] = getMessage(
        'Ce produit n’est pas disponible.',
        'error'
    );

    header(
        'Location: '
            . rtrim(DOMAIN, '/')
            . '/public/cart-view.php'
    );

    exit();
}

/*
|--------------------------------------------------------------------------
| Add product to cart
|--------------------------------------------------------------------------
|
| Composite key prevents collisions such as:
| livre ID 1 and cadeau ID 1.
|
*/

$cartKey =
    $productType
    . ':'
    . $productId;

if (isset($_SESSION['cart'][$cartKey])) {
    $currentQuantity = (int) (
        $_SESSION['cart'][$cartKey]['quantity'] ?? 1
    );

    $_SESSION['cart'][$cartKey]['quantity'] = min(
        $currentQuantity + 1,
        99
    );
} else {
    $_SESSION['cart'][$cartKey] = [
        'cart_key' => $cartKey,
        'id' => (int) $product['id'],
        'title' => (string) (
            $product['title'] ?? ''
        ),
        'price' => (string) (
            $product['price'] ?? ''
        ),
        'image_url' => (string) (
            $product['image_url'] ?? ''
        ),
        'feature' => (string) (
            $product['feature'] ?? ''
        ),
        'quantity' => 1,
        'type' => $productType,
    ];
}

$_SESSION['cart_message'] = getMessage(
    'Le produit a été ajouté au panier.',
    'success'
);

header(
    'Location: '
        . rtrim(DOMAIN, '/')
        . '/public/cart-view.php'
);

exit();
