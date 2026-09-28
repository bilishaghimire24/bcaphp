-- database.sql
-- Just copy this whole file into phpMyAdmin (SQL tab) and hit Go.
-- It will create the database, the 2 tables we need, and a few test articles.

CREATE DATABASE IF NOT EXISTS bilisha;
USE bilisha;

CREATE TABLE categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL
);

CREATE TABLE articles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(200) NOT NULL,
    slug VARCHAR(200) NOT NULL,
    summary VARCHAR(300) NOT NULL,
    body TEXT NOT NULL,
    category_id INT NOT NULL,
    author VARCHAR(100) NOT NULL,
    date_posted DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
);

-- a few categories to start with
INSERT INTO categories (name) VALUES ('Local'), ('World'), ('Business'), ('Sports');

-- a few sample articles so the homepage isn't empty
INSERT INTO articles (title, slug, summary, body, category_id, author) VALUES
('City Council Approves New Riverside Park',
'city-council-approves-new-riverside-park',
'A 12 acre park will open next spring on the eastern riverbank after the council voted yes.',
'The city council voted 7 to 0 on Tuesday to fund a new park along the eastern riverbank.

Construction starts in October and the park should open by next spring. A few residents asked about parking but most people at the meeting seemed happy about it.',
1, 'Maya Chen'),

('Local Bakery Opens Two More Locations',
'local-bakery-opens-two-more-locations',
'The family owned bakery is finally expanding after 10 years in one spot.',
'After ten years running just one shop, the bakery is opening two new locations this fall.

The owners say the recipes will stay exactly the same everywhere, they are even using the same flour supplier for all three shops.',
3, 'Devon Wright'),

('School District Testing a 4 Day School Week',
'school-district-testing-4-day-week',
'Two schools will try a shorter week this January to deal with staff shortages.',
'Two schools in the district are going to test a 4 day school week starting in January.

If it does not work out, the district says they can switch back to 5 days without much trouble.',
1, 'Priya Patel');
