<?php
require_once('settings.php');

$query = isset($_GET['query']) ? $_GET['query'] : '';

$query = htmlspecialchars($query);

if (!empty($query)) {
    try {

        $stmt1 = $conn->prepare("SELECT title FROM livres WHERE title LIKE :query");
        $stmt2 = $conn->prepare("SELECT title FROM papeteries WHERE title LIKE :query");
        $stmt3 = $conn->prepare("SELECT title FROM cadeaux WHERE title LIKE :query");
        
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

    if ($results) {
        echo "<h2>Search Results:</h2>";
        echo "<ul>";
        foreach ($results as $row) {
            echo "<li>" . htmlspecialchars($row['title']) . "</li>";
        }
        echo "</ul>";
    } else {
        echo "No results found.";
    }
} else {
    echo "Please enter a search query.";
}
