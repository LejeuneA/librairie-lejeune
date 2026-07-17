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
| CSRF token
|--------------------------------------------------------------------------
*/

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(
        random_bytes(32)
    );
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
| Normalize existing cart data
|--------------------------------------------------------------------------
|
| Eski session sepetindeki yalnızca sayısal anahtarları,
| yeni "type:id" yapısına dönüştürür.
|
*/

$normalizedCart = [];

foreach (
    $_SESSION['cart']
    as $existingKey => $existingItem
) {
    if (!is_array($existingItem)) {
        continue;
    }

    $productType = (string) (
        $existingItem['type'] ?? ''
    );

    $productId = (int) (
        $existingItem['id'] ?? 0
    );

    if (
        !in_array(
            $productType,
            [
                'livre',
                'papeterie',
                'cadeau',
            ],
            true
        )
        || $productId < 1
    ) {
        continue;
    }

    $cartKey =
        $productType
        . ':'
        . $productId;

    $quantity = (int) (
        $existingItem['quantity'] ?? 1
    );

    $quantity = max(
        1,
        min($quantity, 99)
    );

    $normalizedCart[$cartKey] = [
        'cart_key' => $cartKey,
        'id' => $productId,
        'title' => (string) (
            $existingItem['title'] ?? ''
        ),
        'price' => (string) (
            $existingItem['price'] ?? '0'
        ),
        'image_url' => (string) (
            $existingItem['image_url'] ?? ''
        ),
        'feature' => (string) (
            $existingItem['feature'] ?? ''
        ),
        'quantity' => $quantity,
        'type' => $productType,
    ];
}

$_SESSION['cart'] = $normalizedCart;

$cart = $_SESSION['cart'];
$msg = null;

/*
|--------------------------------------------------------------------------
| Flash message
|--------------------------------------------------------------------------
*/

if (isset($_SESSION['cart_message'])) {
    $msg = $_SESSION['cart_message'];

    unset($_SESSION['cart_message']);
}

/*
|--------------------------------------------------------------------------
| Cart actions
|--------------------------------------------------------------------------
*/

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $submittedToken = (string) (
        $_POST['csrf_token'] ?? ''
    );

    $sessionToken = (string) (
        $_SESSION['csrf_token'] ?? ''
    );

    $cartKey = trim(
        (string) ($_POST['cart_key'] ?? '')
    );

    $action = (string) (
        $_POST['action'] ?? ''
    );

    $allowedActions = [
        'increase',
        'decrease',
        'remove',
    ];

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
    } elseif (
        !preg_match(
            '/^(livre|papeterie|cadeau):[1-9][0-9]*$/',
            $cartKey
        )
    ) {
        $_SESSION['cart_message'] = getMessage(
            'Le produit sélectionné est invalide.',
            'error'
        );
    } elseif (
        !in_array(
            $action,
            $allowedActions,
            true
        )
    ) {
        $_SESSION['cart_message'] = getMessage(
            'L’action demandée est invalide.',
            'error'
        );
    } elseif (
        !isset($_SESSION['cart'][$cartKey])
        || !is_array(
            $_SESSION['cart'][$cartKey]
        )
    ) {
        $_SESSION['cart_message'] = getMessage(
            'Ce produit n’est plus présent dans votre panier.',
            'error'
        );
    } else {
        $currentQuantity = (int) (
            $_SESSION['cart'][$cartKey]['quantity'] ?? 1
        );

        switch ($action) {
            case 'increase':
                $_SESSION['cart'][$cartKey]['quantity'] = min(
                    $currentQuantity + 1,
                    99
                );

                $_SESSION['cart_message'] = getMessage(
                    'La quantité a été mise à jour.',
                    'success'
                );

                break;

            case 'decrease':
                if ($currentQuantity > 1) {
                    $_SESSION['cart'][$cartKey]['quantity'] = $currentQuantity - 1;

                    $_SESSION['cart_message'] = getMessage(
                        'La quantité a été mise à jour.',
                        'success'
                    );
                } else {
                    unset(
                        $_SESSION['cart'][$cartKey]
                    );

                    $_SESSION['cart_message'] = getMessage(
                        'Le produit a été retiré du panier.',
                        'success'
                    );
                }

                break;

            case 'remove':
                unset(
                    $_SESSION['cart'][$cartKey]
                );

                $_SESSION['cart_message'] = getMessage(
                    'Le produit a été retiré du panier.',
                    'success'
                );

                break;
        }
    }

    header(
        'Location: '
            . rtrim(DOMAIN, '/')
            . '/public/cart-view.php'
    );

    exit();
}

/*
|--------------------------------------------------------------------------
| Price helpers
|--------------------------------------------------------------------------
*/

function cartPriceToFloat($price): float
{
    $normalizedPrice = trim(
        (string) $price
    );

    $normalizedPrice = str_replace(
        [
            '€',
            ' ',
            "\xc2\xa0",
        ],
        '',
        $normalizedPrice
    );

    /*
     * 12,50 biçimini 12.50 biçimine çevirir.
     */

    $normalizedPrice = str_replace(
        ',',
        '.',
        $normalizedPrice
    );

    if (!is_numeric($normalizedPrice)) {
        return 0.0;
    }

    return max(
        0,
        (float) $normalizedPrice
    );
}

function formatCartPrice(float $price): string
{
    return number_format(
        $price,
        2,
        ',',
        ' '
    );
}

/*
|--------------------------------------------------------------------------
| Calculate total
|--------------------------------------------------------------------------
*/

$cartTotal = 0.0;

foreach ($cart as $item) {
    $price = cartPriceToFloat(
        $item['price'] ?? 0
    );

    $quantity = max(
        1,
        min(
            (int) (
                $item['quantity'] ?? 1
            ),
            99
        )
    );

    $cartTotal +=
        $price * $quantity;
}

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <?php
    displayHeadSection('Panier d’achat');
    ?>
</head>

<body>

    <header>
        <?php displayNavigationCustomer(); ?>
    </header>

    <main>

        <div class="table-cart container">

            <h1>Votre panier</h1>

            <?php if ($msg !== null): ?>
                <div id="message">
                    <?= $msg ?>
                </div>
            <?php endif; ?>

            <?php if (empty($cart)): ?>

                <p>Votre panier est vide.</p>

                <a
                    href="<?= uiEscape(
                                rtrim(DOMAIN, '/')
                                    . '/public/livres.php'
                            ) ?>"
                    class="btn-primary">
                    Continuer mes achats
                </a>

            <?php else: ?>

                <table>

                    <thead>
                        <tr>
                            <th>Produit</th>
                            <th>Prix</th>
                            <th>Quantité</th>
                            <th>Total</th>
                            <th>Actions</th>
                        </tr>
                    </thead>

                    <tbody>

                        <?php
                        foreach (
                            $cart as $cartKey => $item
                        ):
                            $title = (string) (
                                $item['title'] ?? ''
                            );

                            $feature = (string) (
                                $item['feature'] ?? ''
                            );

                            $price = cartPriceToFloat(
                                $item['price'] ?? 0
                            );

                            $quantity = max(
                                1,
                                min(
                                    (int) (
                                        $item['quantity'] ?? 1
                                    ),
                                    99
                                )
                            );

                            $lineTotal =
                                $price * $quantity;
                        ?>

                            <tr>

                                <td data-cell="produit">
                                    <strong>
                                        <?= uiEscape($title) ?>
                                    </strong>

                                    <?php if (
                                        $feature !== ''
                                    ): ?>
                                        <br>

                                        <small>
                                            <?= uiEscape(
                                                $feature
                                            ) ?>
                                        </small>
                                    <?php endif; ?>
                                </td>

                                <td data-cell="prix">
                                    <?= formatCartPrice(
                                        $price
                                    ) ?>
                                    €
                                </td>

                                <td data-cell="quantité">
                                    <?= $quantity ?>
                                </td>

                                <td data-cell="total">
                                    <?= formatCartPrice(
                                        $lineTotal
                                    ) ?>
                                    €
                                </td>

                                <td data-cell="actions">

                                    <form
                                        method="post"
                                        action="<?= uiEscape(
                                                    rtrim(
                                                        DOMAIN,
                                                        '/'
                                                    )
                                                        . '/public/cart-view.php'
                                                ) ?>">
                                        <input
                                            type="hidden"
                                            name="cart_key"
                                            value="<?= uiEscape(
                                                        $cartKey
                                                    ) ?>">

                                        <input
                                            type="hidden"
                                            name="csrf_token"
                                            value="<?= uiEscape(
                                                        $_SESSION['csrf_token']
                                                    ) ?>">

                                        <div class="btn-ctrl">

                                            <button
                                                class="btn-secondary"
                                                type="submit"
                                                name="action"
                                                value="increase"
                                                aria-label="Augmenter la quantité de <?= uiEscape(
                                                                                            $title
                                                                                        ) ?>">
                                                +
                                            </button>

                                            <button
                                                class="btn-secondary"
                                                type="submit"
                                                name="action"
                                                value="decrease"
                                                aria-label="Diminuer la quantité de <?= uiEscape(
                                                                                        $title
                                                                                    ) ?>">
                                                −
                                            </button>

                                        </div>

                                        <button
                                            class="btn-primary"
                                            type="submit"
                                            name="action"
                                            value="remove">
                                            Supprimer
                                        </button>

                                    </form>

                                </td>

                            </tr>

                        <?php endforeach; ?>

                    </tbody>

                    <tfoot>
                        <tr>
                            <td colspan="3">
                                Total
                            </td>

                            <td>
                                <strong>
                                    <?= formatCartPrice(
                                        $cartTotal
                                    ) ?>
                                    €
                                </strong>
                            </td>

                            <td></td>
                        </tr>
                    </tfoot>

                </table>

            <?php endif; ?>

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
