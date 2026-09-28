<?php
// article.php - shows one full article
include "db.php";

$slug = $_GET['slug'] ?? "";

// using a prepared statement here so nobody can mess with the database
// through the URL
$stmt = $conn->prepare("SELECT articles.*, categories.name AS category_name
                         FROM articles
                         JOIN categories ON categories.id = articles.category_id
                         WHERE slug = ?");
$stmt->bind_param("s", $slug);
$stmt->execute();
$article = $stmt->get_result()->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $article ? e($article['title']) : "Not Found"; ?></title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <header class="site-header">
        <p class="today-date"><?php echo date("l, F j, Y"); ?></p>
        <h1><a href="index.php">Bilisha</a></h1>
    </header>

    <main>
        <?php if (!$article) { ?>

            <p>Sorry, that article does not exist. <a href="index.php">Go back home.</a></p>

        <?php } else { ?>

            <a href="index.php" class="back-link">&larr; back to home</a>

            <article class="full-article">
                <span class="tag"><?php echo e($article['category_name']); ?></span>
                <h1><?php echo e($article['title']); ?></h1>
                <p class="byline">By <?php echo e($article['author']); ?></p>

                <?php
                // the body has blank lines between paragraphs, so split on
                // those and print each one inside its own <p>
                $paragraphs = explode("\n\n", $article['body']);
                foreach ($paragraphs as $para) {
                    echo "<p>" . nl2br(htmlspecialchars($para)) . "</p>";
                }
                ?>
            </article>

        <?php } ?>
    </main>

    <footer>
        <p>&copy; <?php echo date("Y"); ?> Bilisha</p>
    </footer>

</body>
</html>
