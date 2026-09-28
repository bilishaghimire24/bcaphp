<?php
// index.php - homepage, shows all the articles
include "db.php";

// was a category clicked? (0 means show everything)
$active_category = isset($_GET['category']) ? (int)$_GET['category'] : 0;

$category_filter = "";
if ($active_category > 0) {
    $category_filter = "WHERE articles.category_id = $active_category";
}

// get all categories for the nav bar
$categories = $conn->query("SELECT * FROM categories");

// get the articles, newest first
$sql = "SELECT articles.*, categories.name AS category_name
        FROM articles
        JOIN categories ON categories.id = articles.category_id
        $category_filter
        ORDER BY date_posted DESC";
$result = $conn->query($sql);
if (!$result) {
    die("Something went wrong loading the articles: " . $conn->error);
}

$articles = [];
while ($row = $result->fetch_assoc()) {
    $articles[] = $row;
}

// first article = big lead story
// next 5 = side headline list
// everything after that = "more stories" grid at the bottom
$lead = $articles[0] ?? null;
$side_articles = array_slice($articles, 1, 5);
$more_articles = array_slice($articles, 6);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bilisha</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <header class="site-header">
        <p class="today-date"><?php echo date("l, F j, Y"); ?></p>
        <h1><a href="index.php">Bilisha</a></h1>

        <nav aria-label="Categories">
            <a href="index.php" class="<?php echo $active_category === 0 ? 'active' : ''; ?>">All Stories</a>
            <?php while ($cat = $categories->fetch_assoc()) { ?>
                <a href="index.php?category=<?php echo (int)$cat['id']; ?>"
                   class="<?php echo $active_category === (int)$cat['id'] ? 'active' : ''; ?>">
                    <?php echo e($cat['name']); ?>
                </a>
            <?php } ?>
        </nav>
    </header>

    <main>
        <?php if (!$lead) { ?>

            <p class="empty-note">No articles here yet. <a href="add.php">Write the first one.</a></p>

        <?php } else { ?>

            <section class="top-section">
                <!-- big lead story -->
                <article class="lead-story">
                    <span class="tag"><?php echo e($lead['category_name']); ?></span>
                    <h2><a href="article.php?slug=<?php echo urlencode($lead['slug']); ?>"><?php echo e($lead['title']); ?></a></h2>
                    <p class="lead-summary"><?php echo e($lead['summary']); ?></p>
                    <p class="byline">By <?php echo e($lead['author']); ?></p>
                </article>

                <!-- smaller list of other headlines -->
                <?php if ($side_articles) { ?>
                <aside class="side-list">
                    <h3>More Headlines</h3>
                    <?php foreach ($side_articles as $article) { ?>
                        <div class="side-item">
                            <a href="article.php?slug=<?php echo urlencode($article['slug']); ?>"><?php echo e($article['title']); ?></a>
                            <p class="small-text"><?php echo e($article['category_name']); ?></p>
                        </div>
                    <?php } ?>
                </aside>
                <?php } ?>
            </section>

            <?php if ($more_articles) { ?>
            <section class="more-section">
                <h3 class="section-title">More Stories</h3>
                <div class="more-grid">
                    <?php foreach ($more_articles as $article) { ?>
                        <article class="more-item">
                            <span class="tag small"><?php echo e($article['category_name']); ?></span>
                            <h4><a href="article.php?slug=<?php echo urlencode($article['slug']); ?>"><?php echo e($article['title']); ?></a></h4>
                            <p><?php echo e($article['summary']); ?></p>
                        </article>
                    <?php } ?>
                </div>
            </section>
            <?php } ?>

        <?php } ?>
    </main>

    <footer>
        <p>&copy; <?php echo date("Y"); ?> Bilisha</p>
    </footer>

</body>
</html>
