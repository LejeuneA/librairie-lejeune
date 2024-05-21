<?php
require_once('settings.php');

$query = isset($_GET['query']) ? $_GET['query'] : '';

$query = htmlspecialchars($query);

if (!empty($query)) {
    try {
        // Prepare the statements with additional fields
        $stmt1 = $conn->prepare("SELECT title, writer, feature, image_url FROM livres WHERE title LIKE :query");
        $stmt2 = $conn->prepare("SELECT title, feature, image_url FROM papeteries WHERE title LIKE :query");
        $stmt3 = $conn->prepare("SELECT title, feature, image_url FROM cadeaux WHERE title LIKE :query");

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
    displayHeadSection('Gestion des papeteries');
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
        <?php displayNavigation(); ?>
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
        echo "<h1>Search Results</h1>";
        echo "<ul>";
        foreach ($results as $row) {
            echo "<li>";
            echo "<h2>" . htmlspecialchars($row['title']) . "</h2>";
            if (isset($row['writer']) && !empty($row['writer'])) {
                echo "<p>Writer: " . htmlspecialchars($row['writer']) . "</p>";
            }
            if (!empty($row['feature'])) {
                echo "<p>" . htmlspecialchars($row['feature']) . "</p>";
            }
            if (!empty($row['image_url'])) {
                echo "<img src='" . htmlspecialchars($row['image_url']) . "' alt='Image for " . htmlspecialchars($row['title']) . "'>";
            }
            echo "</li>";
        }
        echo "</ul>";
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
