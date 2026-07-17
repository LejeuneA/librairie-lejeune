<?php

require_once __DIR__ . '/settings.php';

requireLogin();

$msg = null;
$tinyMCE = true;
$categories = [];

$addData = [
    'image_url' => '',
    'title' => '',
    'feature' => '',
    'price' => '',
    'content' => '',
    'published_article' => 0,
    'idCategory' => 0,
];

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
| Database and categories
|--------------------------------------------------------------------------
*/

if (!$conn instanceof PDO) {
    $msg = getMessage(
        'La connexion à la base de données est indisponible.',
        'error'
    );
} else {
    $categories = getAllCategoriesDB($conn);

    if (!is_array($categories)) {
        $categories = [];
    }
}

/*
|--------------------------------------------------------------------------
| Add request
|--------------------------------------------------------------------------
*/

if (
    $_SERVER['REQUEST_METHOD'] === 'POST'
    && ($_POST['form'] ?? '') === 'add'
) {
    $addData['title'] = trim(
        (string) ($_POST['title'] ?? '')
    );

    $addData['feature'] = trim(
        (string) ($_POST['feature'] ?? '')
    );

    $addData['price'] = trim(
        (string) ($_POST['price'] ?? '')
    );

    $addData['content'] = trim(
        (string) ($_POST['content'] ?? '')
    );

    $addData['published_article'] =
        isset($_POST['published_article'])
        ? 1
        : 0;

    $addData['idCategory'] = (int) (
        $_POST['idCategory'] ?? 0
    );

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
    } elseif (!isAdmin()) {
        /*
         * Guest burada durur.
         * Dosya yüklenmez ve veritabanına kayıt eklenmez.
         */

        $msg = getMessage(
            'Compte de démonstration : l’ajout d’articles de papeterie est désactivé.',
            'error'
        );
    } elseif (!$conn instanceof PDO) {
        $msg = getMessage(
            'La connexion à la base de données est indisponible.',
            'error'
        );
    } elseif ($addData['title'] === '') {
        $msg = getMessage(
            'Veuillez saisir le titre de la papeterie.',
            'error'
        );
    } elseif (
        mb_strlen($addData['title']) > 255
    ) {
        $msg = getMessage(
            'Le titre de la papeterie est trop long.',
            'error'
        );
    } elseif (
        $addData['idCategory'] < 1
    ) {
        $msg = getMessage(
            'Veuillez sélectionner une catégorie.',
            'error'
        );
    } elseif (
        mb_strlen($addData['feature']) > 255
        || mb_strlen($addData['price']) > 50
    ) {
        $msg = getMessage(
            'Une ou plusieurs informations saisies sont trop longues.',
            'error'
        );
    } else {
        $uploadedFilePath = null;

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
                    $uploadDirectory = dirname(__DIR__) . '/uploads';

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
                            'papeterie-'
                            . bin2hex(
                                random_bytes(12)
                            )
                            . '.'
                            . $extension;

                        $uploadedFilePath =
                            $uploadDirectory
                            . DIRECTORY_SEPARATOR
                            . $fileName;

                        if (
                            !move_uploaded_file(
                                $uploadedFile['tmp_name'],
                                $uploadedFilePath
                            )
                        ) {
                            $uploadedFilePath = null;

                            $msg = getMessage(
                                'L’image n’a pas pu être enregistrée.',
                                'error'
                            );
                        } else {
                            $addData['image_url'] =
                                'uploads/'
                                . $fileName;
                        }
                    }
                }
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Database insertion
        |--------------------------------------------------------------------------
        */

        if ($msg === null) {
            $addResult = addPapeterieDB(
                $conn,
                $addData
            );

            if ($addResult === true) {
                $_SESSION['message'] = getMessage(
                    'La papeterie a été ajoutée avec succès.',
                    'success'
                );

                $_SESSION['csrf_token'] = bin2hex(
                    random_bytes(32)
                );

                header(
                    'Location: add-papeterie.php'
                );

                exit();
            }

            if (
                $uploadedFilePath !== null
                && is_file($uploadedFilePath)
            ) {
                unlink($uploadedFilePath);
            }

            $msg = getMessage(
                'Erreur lors de l’ajout de la papeterie. Veuillez réessayer.',
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
    displayHeadSection('Ajouter une papeterie');
    ?>
</head>

<body>

    <header>
        <?php displayNavigation(); ?>
    </header>

    <main class="edit-content">

        <div class="edit-title">
            <h1>Ajouter une papeterie</h1>

            <?php if (isGuest()): ?>
                <div class="message">
                    <?= getMessage(
                        'Compte de démonstration : vous pouvez consulter et remplir ce formulaire, mais l’ajout est désactivé.',
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
                action="add-papeterie.php"
                method="post"
                enctype="multipart/form-data">
                <input
                    type="hidden"
                    name="form"
                    value="add">

                <input
                    type="hidden"
                    name="csrf_token"
                    value="<?= escapeHtml(
                                $_SESSION['csrf_token']
                            ) ?>">

                <div class="form-top">

                    <div class="form-left">

                        <div class="form-ctrl">
                            <label
                                for="published_article"
                                class="published_article">
                                Status du produit
                                <span>(publication)</span>
                            </label>

                            <?php
                            displayFormRadioBtnArticlePublished(
                                $addData['published_article'],
                                'ADD'
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
                                            $addData['idCategory'] === $categoryId
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
                                            $addData['title']
                                        ) ?>"
                                maxlength="255"
                                required>
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
                                            $addData['feature']
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
                                            $addData['price']
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
                                <img
                                    id="image_preview"
                                    class="image_preview"
                                    src=""
                                    alt="">
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
                                            $addData['content']
                                        ) ?></textarea>
                    </div>
                </div>

                <button
                    type="submit"
                    class="btn-primary">
                    Ajouter
                </button>

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
