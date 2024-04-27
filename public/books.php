<?php
require_once('C:\xampp\htdocs\librairie-lejeune\admin\settings.php');

// Check if user is not identified, redirect to login page
if (!isset($_SESSION['IDENTIFY']) || !$_SESSION['IDENTIFY']) {
    header('Location: login.php');
    exit();
}

$msg = null;
$result = null;
$execute = false;

// Check the database connection
if (!is_object($conn)) {
    $msg = getMessage($conn, 'error');
} else {
    // Fetch all livres from the database
    $result = getAllLivresDB($conn);

    // Check if livres exist
    if (is_array($result) && !empty($result)) {
        $execute = true;
    } else {
        $msg = getMessage('Il n\'y a pas de livre à afficher actuellement', 'error');
    }
}
?>


<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description"
        content="Découvrez Librairie Lejeune pour des livres, fournitures de papeterie et cadeaux uniques. Parcourez notre sélection dès aujourd'hui!">


    <!-- Custom Sass file -->
    <link rel="stylesheet" href="../css/styles.css">

    <!-- Google Fonts Preconnect and Link -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Chelsea+Market&family=Great+Vibes&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">

    <!-- Favicon -->

    <!-- Title -->
    <title>Livres</title>
</head>

<body>
    <!-----------------------------------------------------------------
                               Header
    ------------------------------------------------------------------>
    <header>
        <!-----------------------------------------------------------------
                               Navigation
    ------------------------------------------------------------------>
        <div data-include="navigation"></div>
        <!-----------------------------------------------------------------
                            Navigation end
    ------------------------------------------------------------------>
        <div class="header-image--books">
            <h1>Lire, rêver, s’évader</h1>
            <p>
                Ouvrez un livre, explorez un univers infini.
            </p>
        </div>
    </header>
    <!-----------------------------------------------------------------
                            Header end
    ------------------------------------------------------------------>
    <!-- Main -->
    <main>

        <!-----------------------------------------------------------------
                               Introduction
        ------------------------------------------------------------------>
        <div class="square-right">
            <img src="../assets/components/square-right.png" alt="square">
        </div>

        <section class="introduction">

            <h1>Livres</h1>
            <p>
                Explorez notre collection exceptionnelle de livres allant des best-sellers incontournables aux perles
                littéraires cachées. Plongez-vous dans des mondes imaginaires, découvrez des histoires captivantes et
                trouvez le livre parfait pour chaque passion.
            </p>
        </section>
        <div class="square-left">
            <img src="../assets/components/square-left.png" alt="square">
        </div>
        <!-----------------------------------------------------------------
                               Introduction end
        ------------------------------------------------------------------>
        <!-----------------------------------------------------------------
                                Livres
        ------------------------------------------------------------------>
        <section class="books-container container">
            <!-- Articles -->
            <?php
    // Check if there are livres to display
    if ($execute) {
        // Loop through each livre and generate HTML markup
        foreach ($result as $livre) {
            echo generateLivreHTML($livre);
        }
    } else {
        // Display a message if there are no livres to display
        echo '<p>Il n\'y a pas de livre à afficher actuellement</p>';
    }
    ?>
            <!-- Articles end -->

            <!-- Pagination -->
            <div class="pagination">
                <a href="#">&laquo;</a>
                <a href="#">1</a>
                <a href="#" class="active">2</a>
                <a href="#">3</a>
                <a href="#">4</a>
                <a href="#">5</a>
                <a href="#">6</a>
                <a href="#">&raquo;</a>
            </div>
            <!-- Pagination end -->
        </section>
        <!-----------------------------------------------------------------
                             Livres end
        ------------------------------------------------------------------>

        <!-----------------------------------------------------------------
                                Footer
        ------------------------------------------------------------------>
        <footer>
            <div data-include="footer"></div>
        </footer>
        <!-----------------------------------------------------------------
                            Footer end
        ------------------------------------------------------------------>

        <!-- Font Awesome -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/js/all.min.js"
            integrity="sha512-u3fPA7V8qQmhBPNT5quvaXVa1mnnLSXUep5PS1qo5NRzHwG19aHmNJnj1Q8hpA/nBWZtZD4r4AX6YOt5ynLN2g=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>

        <!-- Include functions.js -->
        <script src="../js/functions.js"></script>

</body>

</html>