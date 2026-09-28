-- queries.sql
-- This is NOT a separate database, it's just a reference sheet.
-- It lists every single query used across the PHP files, so you can see
-- them all in one place instead of hunting through each .php file.

-- ================================
-- Used in index.php
-- ================================

-- get every category, for the nav bar
SELECT * FROM categories;

-- get all articles, newest first (no filter clicked)
SELECT articles.*, categories.name AS category_name
FROM articles
JOIN categories ON categories.id = articles.category_id
ORDER BY date_posted DESC;

-- get articles for ONE category only (when someone clicks a nav link)
-- the real code replaces the "?" with the category id, e.g. 2
SELECT articles.*, categories.name AS category_name
FROM articles
JOIN categories ON categories.id = articles.category_id
WHERE articles.category_id = ?
ORDER BY date_posted DESC;


-- ================================
-- Used in article.php
-- ================================

-- get one article by its slug (the url-friendly title)
SELECT articles.*, categories.name AS category_name
FROM articles
JOIN categories ON categories.id = articles.category_id
WHERE slug = ?;


-- ================================
-- Used in add.php
-- ================================

-- get all categories, to fill the dropdown menu on the form
SELECT * FROM categories;

-- insert the new article once the form is submitted
INSERT INTO articles (title, slug, summary, body, category_id, author)
VALUES (?, ?, ?, ?, ?, ?);


-- ================================
-- A few extra queries you might want later (not used yet, just handy)
-- ================================

-- delete an article by id
-- DELETE FROM articles WHERE id = ?;

-- update an existing article
-- UPDATE articles SET title = ?, summary = ?, body = ? WHERE id = ?;

-- count how many articles are in each category
-- SELECT categories.name, COUNT(articles.id) AS total
-- FROM categories
-- LEFT JOIN articles ON articles.category_id = categories.id
-- GROUP BY categories.id;
