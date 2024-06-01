<?php
require_once('settings.php');

$query = isset($_GET['query']) ? $_GET['query'] : '';

$query = htmlspecialchars($query);

if (!empty($query)) {
    try {
        // Prepare the statements with additional fields
        $stmt1 = $conn->prepare("SELECT title, writer, feature, image_url, idCategory,idLivre FROM livres WHERE title LIKE :query");
        $stmt2 = $conn->prepare("SELECT title, feature, image_url,idCategory,idPapeterie FROM papeteries WHERE title LIKE :query");
        $stmt3 = $conn->prepare("SELECT title, feature, image_url,idCategory,idCadeau FROM cadeaux WHERE title LIKE :query");

        $stmt1->execute(['query' => '%' . $query . '%']);
        $stmt2->execute(['query' => '%' . $query . '%']);
        $stmt3->execute(['query' => '%' . $query . '%']);

        // Fetch results from all tables
        $results1 = $stmt1->fetchAll(PDO::FETCH_ASSOC);
        $results2 = $stmt2->fetchAll(PDO::FETCH_ASSOC);
        $results3 = $stmt3->fetchAll(PDO::FETCH_ASSOC);

        // Combine results
        $results = array_merge($results1, $results2, $results3);
    } catch (PDOException $e) {
        if (DEBUG) {
            echo 'Error: ' . $e->getMessage();
        } else {
            echo 'Error: Database query';
        }
        exit();
    }
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <?php
    // Include the head section
    displayHeadSection('Résultats de recherche');
    displayJSSection();
    ?>
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
    </header>
    <!-----------------------------------------------------------------
                           Header end
    ------------------------------------------------------------------>
    <section class="search-container container">
    <?php
    if ($results) {
        echo "<h1>Résultats de recherche</h1>";
        echo "<p class='search-results-count'>Résultats trouvés: " . count($results) . "</p>";
        echo "<div class='search-results'>";
        echo "<ul>";
        foreach ($results as $row) {
            echo "<li>";
            if ($row['idCategory'] == 1) {
                $type = "Livre";
                echo "<a href='../public/product-livre.php?idLivre=" . $row['idLivre'] . "'>";
            }
            elseif ($row['idCategory'] == 2) {
                $type = "Papeterie";
                echo "<a href='../public/product-papeterie.php?idPapeterie=" . $row['idPapeterie'] . "'>";
            }
            elseif ($row['idCategory'] == 3) {
                $type = "Cadeau";
                echo "<a href='../public/product-cadeau.php?idCadeau=" . $row['idCadeau'] . "'>";
            }
            if (!empty($row['image_url'])) {
                echo "<img src='" . htmlspecialchars($row['image_url']) . "' alt='Image for " . htmlspecialchars($row['title']) . "'>";
            }
            echo "</a>";

            echo "<p class='type'>" . $type . "</p>";
            echo "<h2>" . htmlspecialchars($row['title']) . "</h2>";
            if (isset($row['writer']) && !empty($row['writer'])) {
                echo "<p class='writer'> " . htmlspecialchars($row['writer']) . "</p>";
            }
            if (!empty($row['feature'])) {
                echo "<p class='feature'>" . htmlspecialchars($row['feature']) . "</p>";
            }
            echo "</li>";
        }
        echo "</ul>";
        echo "</div>";
    } else {
        echo "No results found.";
    }
} else {
    echo "Please enter a search query.";
}
    ?>
    </section>


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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/js/all.min.js" integrity="sha512-u3fPA7V8qQmhBPNT5quvaXVa1mnnLSXUep5PS1qo5NRzHwG19aHmNJnj1Q8hpA/nBWZtZD4r4AX6YOt5ynLN2g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <!-- Include functions.js -->
    <script src="../js/functions.js"></script>
</body>

</html>
