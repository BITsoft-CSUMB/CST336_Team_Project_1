<!--
  **BM UPDATING NOW**
  Last Updated: BM 30-Jan @ 1218
-->

<?php
require '../db_connection.php'; // Open database connection.

/*
    Get books. 

*/
function getBooks() {
  global $dbConn;
  $sql = "SELECT books.id, 
            books.title, 
            books.synopsis, 
            books.price, 
            authors.name AS author 
          FROM books 
          LEFT JOIN authors 
          ON books.author_id = authors.id ";
  $sort = isset($_GET['sort']) ? $_GET['sort'] : null;
  switch ($sort) {
    case "title":
      $sql .= "ORDER BY books.title;";
      break;
    case "author":
      $sql .= "ORDER BY authors.name;";
      break;
    case "price":
      $sql .= "ORDER BY books.price;";
      break;
    default:
      $sql .= "ORDER BY books.id;";
      break;
  }
  $stmt = $dbConn -> prepare($sql);
  $stmt -> execute();
  return $stmt->fetchAll();
}

?>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <meta name="author" content="Team 6 - Bitsoft">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Book Collection</title>

  <!-- Support John's directory structure -->
  <!-- <link rel="stylesheet" type="text/css" href="library.css">
  <link rel="shortcut icon" href="../media/assign4-favicon.ico">
  <style>
    body {
      background-image: url("../media/background-bookcase.jpg");
    }
  <?php 
    $down_arrow_img = '<img class="down_arrow" src="../media/down.png">';
  ?> -->

  <!-- Support Brittany's directory structure -->
  <link rel="stylesheet" type="text/css" href="library.css">
  <link rel="shortcut icon" href="favicon.ico">
  <style>
    body {
      background-image: url("background-library.jpg");
    }
  </style>
  <?php 
    $down_arrow_img = '<img class="down_arrow" src="down.png">';
  ?>

  <!-- Support Ashley's directory structure (Ashley -> Update as needed) -->
  <!-- <link rel="stylesheet" type="text/css" href="library.css">
  <link rel="shortcut icon" href="favicon.ico">
  <style>
    body {
      background-image: url("background-library.jpg");
    }
  </style>
  <?php 
    $down_arrow_img = '<img class="down_arrow" src="down.png">';
  ?> -->

</head>

<body>
  <div class="content">
    <h1>BITsoft Book Collection</h1>
    <table class="book_collection">
      <tr>
        <th onClick="javascript:location.href='?sort=id'">
          <h4>ID<?= $down_arrow_img ?></h4>
        </th>
        <th class="header_title" onClick="javascript:location.href='?sort=title'">
          <h4>Title<?= $down_arrow_img ?></h4>
        </th>
        <th class="header_author" onClick="javascript:location.href='?sort=author'">
          <h4>Author<?= $down_arrow_img ?></h4>
        </th>
        <th>
          <h4>Synopsis</h4>
        </th>
        <th class="header_price" onClick="javascript:location.href='?sort=price'">
          <h4>Price<?= $down_arrow_img ?></h4>
        </th>
        <th></th>
      </tr>

      <?php
        // Populate table with book entries, initially sorting by ID.
        $bookList = getBooks();
        foreach ($bookList as $book) {
      ?>
        <tr onclick="document.getElementById('light').style.display='block';document.getElementById('fade').style.display='block'">
          <td class="book_id"><?= $book['id'] ?></td>
          <td class="book_title"><?= $book['title'] ?></td>
          <td><?= $book['author'] ?></td>
          <!-- TODO: Add an onClick pop-up that shows full synopsis & details. -->
          <td><?= substr($book['synopsis'], 0, 125)?>...</td>
          <td><?= $book['price'] ?></td>
          <td><a href=".?edit="<?= $book['id']?>"">Edit</a></td>
        </tr>
      <?php
        } // close foreach
      ?>
    </table>

    <table class="add_book">
      <tr>
        <th colspan=2>New Book</th>
      </tr>
      <tr>
        <td class="col_header">Title:</td>
        <td><input type=text name=title size=25 maxlength=50></td>
      </tr>
      <tr>
        <td class="col_header">Author:</td>
        <td><!-- TODO: Add select input here with option of other to create new author. --></td>
      </tr>
      <tr>
        <td class="col_header">Synopsis:</td>
        <td><textarea cols=25 rows=5></textarea></td>
      </tr>
      <tr>
        <td class="col_header">Release Date:</td>
        <td><input type=text name=release_date size=25></td>
      </tr>
      <tr>
        <td class="col_header">ISBN:</td>
        <td><input type=text name=isbn size=15 maxlength=10></td>
      </tr>
      <tr>
        <td class="col_header">Publisher:</td>
        <td><!-- TODO: See author comment above. --></td>
      </tr>
      <tr>
        <td class="col_header">Price:</td>
        <td><input type=text name=price size=15 maxlength=10></td>
      </tr>
    </table>
  </div>

  <div id="light" class="white_content">
    <table border=0>
      <th colspan=2 align=right onclick = "document.getElementById('light').style.display='none';document.getElementById('fade').style.display='none'">Close</th>
      <tr>
        <td>Title</td>
        <td rowspan=5>picOfCover</td>
      </tr>
      <tr>
        <td>ISBN: isbn</td>
      </tr>
      <tr>
        <td>by: author</td>
      </tr>
      <tr>
        <td>Date: release_date</td>
      </tr>
      <tr>
        <td>Pub: publisher</td>
      </tr>
      <tr>
        <td colspan=2>Synopsis: synopsis goes here asdf asdf asdf asdf asdf asdf asdf asdf asdf asdf asdf asdf asdf asdf asdf asdf asdf asdf asdf asdf asdf asdf asdf asdf asdf asdf asdf </td>
      </tr>
    </table>
  </div>

  <div id="fade" class="black_overlay"></div>
  
</body>
</html>
