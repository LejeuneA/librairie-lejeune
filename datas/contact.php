<?php

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../public/contact.php');
    exit();
}

require_once __DIR__ . '/../admin/conf/conf-db.php';

$firstName = trim((string) ($_POST['firstName'] ?? ''));
$lastName = trim((string) ($_POST['lastName'] ?? ''));
$email = trim((string) ($_POST['email'] ?? ''));
$phone = trim((string) ($_POST['phone'] ?? ''));
$message = trim((string) ($_POST['message'] ?? ''));

if (
    $firstName === ''
    || $lastName === ''
    || $email === ''
    || $phone === ''
    || $message === ''
) {
    header(
        'Location: ../public/contact.php?error=missing-fields'
    );
    exit();
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    header(
        'Location: ../public/contact.php?error=invalid-email'
    );
    exit();
}

if (
    strlen($firstName) > 100
    || strlen($lastName) > 100
    || strlen($email) > 190
    || strlen($phone) > 50
    || strlen($message) > 5000
) {
    header(
        'Location: ../public/contact.php?error=invalid-length'
    );
    exit();
}

try {
    $dsn =
        'mysql:host=' . SERVER_NAME
        . ';dbname=' . DB_NAME
        . ';charset=utf8mb4';

    $pdo = new PDO(
        $dsn,
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

    $statement = $pdo->prepare(
        'INSERT INTO contact (
            firstName,
            lastName,
            email,
            phone,
            message
        ) VALUES (
            :firstName,
            :lastName,
            :email,
            :phone,
            :message
        )'
    );

    $statement->execute([
        'firstName' => $firstName,
        'lastName' => $lastName,
        'email' => $email,
        'phone' => $phone,
        'message' => $message,
    ]);

    header(
        'Location: ../public/contact.php?success=1'
    );
    exit();
} catch (Throwable $exception) {
    error_log(
        'Librairie contact form error: '
            . $exception->getMessage()
    );

    header(
        'Location: ../public/contact.php?error=server'
    );
    exit();
}
