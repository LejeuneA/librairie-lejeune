<?php

require_once __DIR__ . '/settings.php';

requireLogin();

$msg = null;
$tinyMCE = true;
$livre = null;
$categories = [];

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
| Flash message
|--------------------------------------------------------------------------
*/

if (isset($_SESSION['message'])) {
    $msg = $_SESSION['message'];

    unset($_SESSION['message']);
}

/*
|--------------------------------------------------------------------------
| Validate book ID
|--------------------------------------------------------------------------
*/

$idLivre = filter_input(
    INPUT_GET,
    'idLivre',
    FILTER_VALIDATE_INT,
    [
        'options' => [
            'min_range' => 1,
        ],
    ]
);

if ($idLivre === false || $idLivre === null) {
    $_SESSION['message'] = getMessage(
        'Le livre sélectionné est invalide.',
        'error'
    );

    header('Location: manager-livre.php');
    exit();
}

/*
|--------------------------------------------------------------------------
| Database connection
|--------------------------------------------------------------------------
*/

if (!$conn instanceof PDO) {
    $_SESSION['message'] = getMessage(
        'La connexion à la base de données est indisponible.',
        'error'
    );

    header('Location: manager-livre.php');
    exit();
}

/*
|--------------------------------------------------------------------------
| Retrieve book and categories
|--------------------------------------------------------------------------
*/

$livre = getLivreByIDDB(
    $conn,
    $idLivre
);

if (
    !is_array($livre)
    || isset($livre['error'])
    || empty($livre)
) {
    $_SESSION['message'] = getMessage(
        'Le livre demandé est introuvable.',
        'error'
    );

    header('Location: manager-livre.php');
    exit();
}

$categories = getCategoryNamesFromDB($conn);

if (!is_array($categories)) {
    $categories = [];
}

/*
|--------------------------------------------------------------------------
| Form data
|--------------------------------------------------------------------------
*/

$formData = [
    'idLivre' => $idLivre,
    'image_url' => (string) (
        $livre['image_url'] ?? ''
    ),
    'title' => (string) (
        $livre['title'] ?? ''
    ),
    'writer' => (string) (
        $livre['writer'] ?? ''
    ),
    'feature' => (string) (
        $livre['feature'] ?? ''
    ),
    'price' => (string) (
        $livre['price'] ?? ''
    ),
    'content' => html_entity_decode(
        (string) ($livre['content'] ?? ''),
        ENT_QUOTES | ENT_HTML5,
        'UTF-8'
    ),
    'published_article' => (int) (
        $livre['active'] ?? 0
    ),
    'idCategory' => (int) (
        $livre['idCategory'] ?? 0
    ),
];

/*
|--------------------------------------------------------------------------
| Update request
|--------------------------------------------------------------------------
*/

if (
    $_SERVER['REQUEST_METHOD'] === 'POST'
    && ($_POST['update_form'] ?? '') === '1'
) {
    /*
     * Formu hata durumunda yeniden doldurabilmek için
     * gönderilen değerleri alıyoruz.
     */

    $formData['title'] = trim(
        (string) ($_POST['title'] ?? '')
    );

    $formData['writer'] = trim(
        (string) ($_POST['writer'] ?? '')
    );

    $formData['feature'] = trim(
        (string) ($_POST['feature'] ?? '')
    );

    $formData['price'] = trim(
        (string) ($_POST['price'] ?? '')
    );

    $formData['content'] = trim(
        (string) ($_POST['content'] ?? '')
    );

    $formData['published_article'] =
        isset($_POST['published_article'])
        ? 1
        : 0;

    $formData['idCategory'] = (int) (
        $_POST['idCategory'] ?? 0
    );

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
        $msg = getMessage(
            'Votre session a expiré. Veuillez réessayer.',
            'error'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Guest protection
    |--------------------------------------------------------------------------
    */ elseif (!isAdmin()) {
        $msg = getMessage(
            'Compte de démonstration : la modification des livres est désactivée.',
            'error'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Form validation
    |--------------------------------------------------------------------------
    */ elseif ($formData['title'] === '') {
        $msg = getMessage(
            'Veuillez saisir le titre du livre.',
            'error'
        );
    } elseif (
        mb_strlen($formData['title']) > 255
    ) {
        $msg = getMessage(
            'Le titre du livre est trop long.',
            'error'
        );
    } elseif (
        $formData['idCategory'] < 1
    ) {
        $msg = getMessage(
            'Veuillez sélectionner une catégorie.',
            'error'
        );
    } elseif (
        mb_strlen($formData['writer']) > 255
        || mb_strlen($formData['feature']) > 255
        || mb_strlen($formData['price']) > 50
    ) {
        $msg = getMessage(
            'Une ou plusieurs informations saisies sont trop longues.',
            'error'
        );
    } else {
        $oldImagePath = (string) (
            $livre['image_url'] ?? ''
        );

        $newUploadedFilePath = null;

        /*
        |--------------------------------------------------------------------------
        | Optional image upload
        |--------------------------------------------------------------------------
        */

        if (
            isset($_FILES['image_upload'])
            && (
                $_FILES['image_upload']['error']
                ?? UPLOAD_ERR_NO_FILE
            ) !== UPLOAD_ERR_NO_FILE
        ) {
            $uploadedFile = $_FILES['image_upload'];

            if (
                $uploadedFile['error']
                !== UPLOAD_ERR_OK
            ) {
                $msg = getMessage(
                    'Une erreur est survenue pendant le téléchargement de l’image.',
                    'error'
                );
            } elseif (
                (int) $uploadedFile['size']
                > 5 * 1024 * 1024
            ) {
                $msg = getMessage(
                    'L’image ne peut pas dépasser 5 Mo.',
                    'error'
                );
            } else {
                $fileInfo = new finfo(
                    FILEINFO_MIME_TYPE
                );

                $mimeType = $fileInfo->file(
                    $uploadedFile['tmp_name']
                );

                $allowedMimeTypes = [
                    'image/jpeg' => 'jpg',
                    'image/png' => 'png',
                    'image/webp' => 'webp',
                    'image/gif' => 'gif',
                ];

                if (
                    !isset(
                        $allowedMimeTypes[$mimeType]
                    )
                ) {
                    $msg = getMessage(
                        'Le format de l’image est invalide. Utilisez JPG, PNG, WebP ou GIF.',
                        'error'
                    );
                } else {
                    $uploadDirectory =
                        __DIR__ . '/uploads';

                    if (
                        !is_dir($uploadDirectory)
                        && !mkdir(
                            $uploadDirectory,
                            0755,
                            true
                        )
                    ) {
                        $msg = getMessage(
                            'Le dossier de téléchargement est indisponible.',
                            'error'
                        );
                    } else {
                        $extension =
                            $allowedMimeTypes[$mimeType];

                        $fileName =
                            'livre-'
                            . bin2hex(
                                random_bytes(12)
                            )
                            . '.'
                            . $extension;

                        $newUploadedFilePath =
                            $uploadDirectory
                            . DIRECTORY_SEPARATOR
                            . $fileName;

                        if (
                            !move_uploaded_file(
                                $uploadedFile['tmp_name'],
                                $newUploadedFilePath
                            )
                        ) {
                            $newUploadedFilePath = null;

                            $msg = getMessage(
                                'L’image n’a pas pu être enregistrée.',
                                'error'
                            );
                        } else {
                            $formData['image_url'] =
                                'uploads/'
                                . $fileName;
                        }
                    }
                }
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Database update
        |--------------------------------------------------------------------------
        */

        if ($msg === null) {
            $updateResult = updateLivreDB(
                $conn,
                [
                    'idLivre' =>
                    $idLivre,

                    'image_url' =>
                    $formData['image_url'],

                    'title' =>
                    $formData['title'],

                    'writer' =>
                    $formData['writer'],

                    'feature' =>
                    $formData['feature'],

                    'price' =>
                    $formData['price'],

                    'content' =>
                    $formData['content'],

                    'published_article' =>
                    $formData['published_article'],

                    'idCategory' =>
                    $formData['idCategory'],
                ]
            );

            if ($updateResult === true) {
                /*
                 * Yeni görsel başarıyla kaydedildiyse
                 * eski upload dosyasını temizliyoruz.
                 */

                if (
                    $newUploadedFilePath !== null
                    && str_starts_with(
                        $oldImagePath,
                        'uploads/'
                    )
                ) {
                    $oldImageFullPath =
                        __DIR__
                        . DIRECTORY_SEPARATOR
                        . str_replace(
                            '/',
                            DIRECTORY_SEPARATOR,
                            $oldImagePath
                        );

                    if (
                        is_file($oldImageFullPath)
                        && realpath($oldImageFullPath)
                        !== realpath(
                            $newUploadedFilePath
                        )
                    ) {
                        unlink($oldImageFullPath);
                    }
                }

                $_SESSION['message'] = getMessage(
                    'Les modifications ont été enregistrées.',
                    'success'
                );

                $_SESSION['csrf_token'] =
                    bin2hex(random_bytes(32));

                header(
                    'Location: edit-livre.php?idLivre='
                        . $idLivre
                );

                exit();
            }

            /*
             * Veritabanı güncellenmediyse yeni
             * yüklenen görseli sunucuda bırakmıyoruz.
             */

            if (
                $newUploadedFilePath !== null
                && is_file($newUploadedFilePath)
            ) {
                unlink($newUploadedFilePath);
            }

            $msg = getMessage(
                'Erreur lors de la modification du produit. Veuillez réessayer.',
                'error'
            );
        }
    }
}

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <?php
    displayHeadSection('Éditer un livre');
    ?>
</head>

<body>

    <header>
        <?php displayNavigation(); ?>
    </header>

    <main class="edit-content">

        <div class="edit-title">
            <h1>Éditer un livre</h1>

            <?php if (isGuest()): ?>
                <div class="message">
                    <?= getMessage(
                        'Compte de démonstration : vous pouvez consulter et remplir ce formulaire, mais les modifications sont désactivées.',
                        'success'
                    ) ?>
                </div>
            <?php endif; ?>

            <div class="message">
                <?= $msg ?? '' ?>
            </div>
        </div>

        <div class="edit-form container">

            <form
                action="edit-livre.php?idLivre=<?= $idLivre ?>"
                method="post"
                enctype="multipart/form-data">
                <input
                    type="hidden"
                    name="update_form"
                    value="1">

                <input
                    type="hidden"
                    name="csrf_token"
                    value="<?= escapeHtml(
                                $_SESSION['csrf_token']
                            ) ?>">

                <div class="form-top">

                    <div class="form-left">

                        <div class="checkbox-ctrl">
                            <label
                                for="published_article"
                                class="published_article">
                                Status du produit
                                <span>(publication)</span>
                            </label>

                            <?php
                            displayFormRadioBtnArticlePublished(
                                $formData['published_article'],
                                'EDIT'
                            );
                            ?>
                        </div>

                        <div class="form-ctrl">
                            <label
                                for="idCategory"
                                class="form-ctrl">
                                Catégorie
                            </label>

                            <select
                                id="idCategory"
                                name="idCategory"
                                class="form-ctrl"
                                required>
                                <option value="">
                                    Sélectionner une catégorie
                                </option>

                                <?php
                                foreach (
                                    $categories as $category
                                ):
                                    $categoryId = (int) (
                                        $category['idCategory'] ?? 0
                                    );

                                    $categoryName =
                                        $category['nameOfCategory'] ?? '';
                                ?>

                                    <option
                                        value="<?= $categoryId ?>"
                                        <?= (
                                            $categoryId
                                            === $formData['idCategory']
                                        )
                                            ? 'selected'
                                            : '' ?>>
                                        <?= escapeHtml(
                                            $categoryName
                                        ) ?>
                                    </option>

                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="form-ctrl">
                            <label
                                for="title"
                                class="form-ctrl">
                                Titre
                            </label>

                            <input
                                type="text"
                                class="form-ctrl"
                                id="title"
                                name="title"
                                value="<?= escapeHtml(
                                            $formData['title']
                                        ) ?>"
                                maxlength="255"
                                required>
                        </div>

                        <div class="form-ctrl">
                            <label
                                for="writer"
                                class="form-ctrl">
                                Auteur
                            </label>

                            <input
                                type="text"
                                class="form-ctrl"
                                id="writer"
                                name="writer"
                                value="<?= escapeHtml(
                                            $formData['writer']
                                        ) ?>"
                                maxlength="255">
                        </div>

                        <div class="form-ctrl">
                            <label
                                for="feature"
                                class="form-ctrl">
                                Caractéristiques
                            </label>

                            <input
                                type="text"
                                class="form-ctrl"
                                id="feature"
                                name="feature"
                                value="<?= escapeHtml(
                                            $formData['feature']
                                        ) ?>"
                                maxlength="255">
                        </div>

                        <div class="form-ctrl">
                            <label
                                for="price"
                                class="form-ctrl">
                                Prix
                            </label>

                            <input
                                type="text"
                                class="form-ctrl"
                                id="price"
                                name="price"
                                value="<?= escapeHtml(
                                            $formData['price']
                                        ) ?>"
                                maxlength="50">
                        </div>

                    </div>

                    <div class="form-right">

                        <div class="form-ctrl">
                            <label
                                for="image_upload"
                                class="form-ctrl">
                                Uploader l’image
                            </label>

                            <input
                                type="file"
                                class="form-ctrl"
                                id="image_upload"
                                name="image_upload"
                                accept="image/jpeg,image/png,image/webp,image/gif"
                                onchange="previewImage(this)">
                        </div>

                        <div class="form-ctrl">
                            <label
                                for="image_preview"
                                class="form-ctrl">
                                Aperçu de l’image
                            </label>

                            <div>
                                <input
                                    type="text"
                                    class="form-ctrl image_url"
                                    id="image_url"
                                    value="<?= escapeHtml(
                                                $formData['image_url']
                                            ) ?>"
                                    readonly>

                                <img
                                    id="image_preview"
                                    class="image_preview"
                                    src="<?= escapeHtml(
                                                $formData['image_url']
                                            ) ?>"
                                    alt="Aperçu du livre">
                            </div>
                        </div>

                    </div>

                </div>

                <div class="form-bottom">
                    <div class="form-ctrl">
                        <label
                            for="content"
                            class="form-ctrl">
                            Contenu
                        </label>

                        <textarea
                            class="content"
                            id="content"
                            name="content"
                            rows="5"><?= escapeHtml(
                                            $formData['content']
                                        ) ?></textarea>
                    </div>
                </div>

                <button
                    type="submit"
                    class="btn-primary">
                    Sauvegarder
                </button>

                <a
                    class="btn-primary"
                    href="article-livre.php?idLivre=<?= $idLivre ?>">
                    Afficher
                </a>

            </form>

        </div>

    </main>

    <footer>
        <?php displayFooter(); ?>
    </footer>

    <?php displayJSSection($tinyMCE); ?>

    <script
        src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/js/all.min.js"
        integrity="sha512-u3fPA7V8qQmhBPNT5quvaXVa1mnnLSXUep5PS1qo5NRzHwG19aHmNJnj1Q8hpA/nBWZtZD4r4AX6YOt5ynLN2g=="
        crossorigin="anonymous"
        referrerpolicy="no-referrer"></script>

    <script src="../js/functions.js"></script>

</body>

</html>
