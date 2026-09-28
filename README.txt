HOW TO RUN THIS
================

Everything is in this one folder, no subfolders. 8 files:

  db.php               -> connects to the database (every page uses this)
  database.sql         -> run this once to create the database + tables
  queries.sql           -> reference sheet, every query the app uses
  index.php            -> the homepage
  article.php          -> shows one full article
  add.php              -> a form to post new articles
  style.css            -> all the styling
  design-mockup.html   -> visual design reference (open it in a browser)

Steps:

1. Install XAMPP (or MAMP/Laragon if you're not on Windows).
2. Put this whole "bilisha" folder inside htdocs
   (usually C:\xampp\htdocs\bilisha on Windows).
3. Start Apache and MySQL from the XAMPP control panel.
4. Open http://localhost/phpmyadmin, click the SQL tab,
   paste in everything from database.sql, and click Go.
5. Now open http://localhost/bilisha/ in your browser.

That's it, you should see the homepage with 3 sample articles.

To add your own article, go to http://localhost/bilisha/add.php

A couple of honest notes:
- add.php has no password on it, anyone who finds the link can post.
  That's fine for testing on your own computer, just don't upload this
  to a real live website without adding a login first.
- db.php assumes the default XAMPP login (username "root", no password).
  If your MySQL is set up differently, change those two lines in db.php.
