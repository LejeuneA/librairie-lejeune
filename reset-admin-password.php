<?php

$allowedAddresses = [
    '127.0.0.1',
    '::1',
];

$remoteAddress = $_SERVER['REMOTE_ADDR'] ?? '';

if (!in_array($remoteAddress, $allowedAddresses, true)) {
    http_response_code(403);
    exit('This page is available only on localhost.');
}

require_once __DIR__ . '/admin/conf/conf-db.php';

$message = null;
$messageType = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim((string) ($_POST['email'] ?? ''));
    $password = (string) ($_POST['password'] ?? '');

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = 'Geçerli bir e-posta adresi yaz.';
        $messageType = 'error';
    } elseif (strlen($password) < 4) {
        $message = 'Parola en az 4 karakter olmalı.';
        $messageType = 'error';
    } else {
        try {
            $pdo = new PDO(
                'mysql:host=' . SERVER_NAME
                    . ';dbname=' . DB_NAME
                    . ';charset=utf8mb4',
                USER_NAME,
                USER_PWD,
                [
                    PDO::ATTR_ERRMODE =>
                    PDO::ERRMODE_EXCEPTION,

                    PDO::ATTR_DEFAULT_FETCH_MODE =>
                    PDO::FETCH_ASSOC,

                    PDO::ATTR_EMULATE_PREPARES =>
                    false,
                ],
            );

            $passwordHash = password_hash(
                $password,
                PASSWORD_DEFAULT,
            );

            $statement = $pdo->prepare(
                'UPDATE users
                 SET passwd = :password
                 WHERE email = :email'
            );

            $statement->execute([
                'password' => $passwordHash,
                'email' => $email,
            ]);

            if ($statement->rowCount() < 1) {
                $message =
                    'Bu e-posta adresiyle kullanıcı bulunamadı veya değer değişmedi.';

                $messageType = 'error';
            } else {
                $message =
                    'Parola başarıyla hash’lenerek veritabanına kaydedildi.';

                $messageType = 'success';
            }
        } catch (Throwable $exception) {
            $message =
                'Veritabanı güncellenemedi: '
                . $exception->getMessage();

            $messageType = 'error';
        }
    }
}

?>

<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0">

    <title>Admin Password Reset</title>
</head>

<body>
    <h1>Admin parolasını güncelle</h1>

    <?php if ($message !== null): ?>
        <p>
            <?= htmlspecialchars(
                $message,
                ENT_QUOTES,
                'UTF-8',
            ) ?>
        </p>
    <?php endif; ?>

    <form method="post">
        <div>
            <label for="email">
                Admin e-posta adresi
            </label>

            <input
                type="email"
                id="email"
                name="email"
                required>
        </div>

        <div>
            <label for="password">
                Kullanmak istediğin parola
            </label>

            <input
                type="password"
                id="password"
                name="password"
                minlength="4"
                required>
        </div>

        <button type="submit">
            Parolayı güncelle
        </button>
    </form>
</body>

</html>
