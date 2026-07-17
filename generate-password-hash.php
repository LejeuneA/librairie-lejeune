<?php

$hash = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $password = (string) ($_POST['password'] ?? '');

    if ($password !== '') {
        $hash = password_hash(
            $password,
            PASSWORD_DEFAULT,
        );
    }
}

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Password Hash Generator</title>
</head>

<body>
    <h1>Password Hash Generator</h1>

    <form method="post">
        <label for="password">
            Mot de passe
        </label>

        <input
            type="password"
            id="password"
            name="password"
            required>

        <button type="submit">
            Générer le hash
        </button>
    </form>

    <?php if ($hash !== null): ?>
        <h2>Hash généré</h2>

        <textarea
            rows="4"
            cols="100"
            readonly><?= htmlspecialchars(
                            $hash,
                            ENT_QUOTES,
                            'UTF-8',
                        ) ?></textarea>
    <?php endif; ?>
</body>

</html>
