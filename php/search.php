<?php
include 'config.php';

$query = isset($_GET['query']) ? $_GET['query'] : '';
$sql = "SELECT * FROM books WHERE title LIKE :query OR author LIKE :query OR genre LIKE :query";
$stmt = $pdo->prepare($sql);
$stmt->execute(['query' => '%' . $query . '%']);
$books = $stmt->fetchAll();

if (!empty($books)) {
    foreach ($books as $book) {
        echo '<div>';
        echo '<h2>' . htmlspecialchars($book['title']) . '</h2>';
        echo '<p>' . htmlspecialchars($book['author']) . '</p>';
        echo '<p>' . htmlspecialchars($book['price']) . ' руб.</p>';
        echo '<p>' . htmlspecialchars($book['description']) . '</p>';
        echo '<p>' . htmlspecialchars($book['genre']) . '</p>';
        echo '</div>';
    }
} else {
    echo 'Книги не найдены.';
}
?>
