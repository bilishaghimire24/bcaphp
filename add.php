<?php
// add.php - a plain form for posting a new article
// (there's no login on this page, so don't put this online as-is,
// only use it while building/testing on your own computer)
include "db.php";

$categories = $conn->query("SELECT * FROM categories");
$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $title = $_POST['title'];
    $summary = $_POST['summary'];
    $body = $_POST['body'];
    $category_id = $_POST['category_id'];
    $author = $_POST['author'] !== "" ? $_POST['author'] : "Staff Writer";

    // turn the title into something-like-this for the url
    $slug = strtolower($title);
    $slug = preg_replace('/[^a-z0-9]+/', '-', $slug);
    $slug = trim($slug, '-');

    $stmt = $conn->prepare("INSERT INTO articles (title, slug, summary, body, category_id, author)
                             VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssis", $title, $slug, $summary, $body, $category_id, $author);
    $stmt->execute();

    $message = "Article posted! Go check the homepage.";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Article</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <header class="site-header">
        <h1><a href="index.php">Bilisha</a></h1>
        <p>Add a new article</p>
    </header>

    <main>
        <?php if ($message) { ?>
            <p class="message-box"><?php echo e($message); ?></p>
        <?php } ?>

        <form method="post" class="add-form">

            <label>Title</label>
            <input type="text" name="title" required>

            <label>Category</label>
            <select name="category_id" required>
                <?php while ($cat = $categories->fetch_assoc()) { ?>
                    <option value="<?php echo (int)$cat['id']; ?>"><?php echo e($cat['name']); ?></option>
                <?php } ?>
            </select>

            <label>Author</label>
            <input type="text" name="author" placeholder="Staff Writer">

            <label>Summary</label>
            <textarea name="summary" rows="2" required></textarea>

            <label>Full Article (leave a blank line between paragraphs)</label>
            <textarea name="body" rows="10" required></textarea>

            <button type="submit">Post Article</button>
        </form>
    </main>

    <footer>
        <p>&copy; <?php echo date("Y"); ?> Bilisha</p>
    </footer>

</body>
</html>
