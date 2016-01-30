<?php
// last update by BM 29-Jan @ 1937
require '../db_connection.php'; // Open database connection.

function getBooks() {
    global $dbConn;
    $sql = "SELECT books.id, 
              books.title, 
              books.isbn, 
              books.release_date, 
              books.synopsis, 
              books.price, 
              authors.name AS author, 
              publishers.name AS publisher
            FROM books 
            LEFT JOIN authors 
            ON books.author_id = authors.id 
            LEFT JOIN publishers 
            ON books.publisher_id = publishers.id
            ORDER BY books.id;";
    $stmt = $dbConn -> prepare($sql);
    $stmt -> execute();
    return $stmt->fetchAll();
}
?>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <title>Book Collection</title>
  <meta name="author" content="Team 6 - Bitsoft">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="shortcut icon" href="../media/assign4/favicon.ico">
  <style>
  /* Color Palette:
     #334139 -> Lighter Green    #1E2D24 -> Dark Green
     #E6E8E6 -> Off White        #FFE0B5 -> Light Tan
     #433F6B -> Indigo           */
  body {
    background-image: url("../media/assign4/background-library.jpg");
  }
  h1 {
    color: #1E2D24;
    text-align: center;
  }
  table {
    margin: auto;
    background-color: #E6E8E6;
  }
  tr:hover {
    background-color: #433F6B;
    color: white;
  }
  th {
    background-color: #FFE0B5;
  }
  td {
    border-bottom: 1px solid #ddd;
    padding: 5px;
  }
  .content {
    width: 1000px;
    margin: auto;
    background-color: rgba(248, 247, 216, 0.75);
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 200%;
  }
  </style>
</head>

<body>
  <div class="content">
    <h1>Book Collection</h1>
    <table border=0 width=1000>
      <tr>
        <th width=100>Title</th> <!--Add clickable sort-by buttons -->
        <th width=100>Author</th>
        <th>Synopsis</th>
        <!--<th width=20>Release Date</th>
        <th width=20>ISBN</th>
        <th width=100>Publisher</th>-->
        <th width=15>Price</th>
        <th> </th>
      </tr>
<?php
  $bookList = getBooks();
  foreach ($bookList as $book) {
    echo "\t\t\t<tr>\n";
    echo "\t\t\t\t<td><i>" . $book['title'] . "</i></td>\n";
    echo "\t\t\t\t<td>" . $book['author'] . "</td>\n";
    echo "\t\t\t\t<td>" . substr($book['synopsis'], 0, 140) . "...</td>\n"; // Add an onClick pop-up that shows full synopsis & details
    //echo "\t\t\t\t<td>" . $book['release_date'] . "</td>\n";
    //echo "\t\t\t\t<td>" . $book['isbn'] . "</td>\n"; // Add these to details page (onClick)
    //echo "\t\t\t\t<td>" . $book['publisher'] . "</td>\n";
    echo "\t\t\t\t<td>" . $book['price'] . "</td>\n";
        echo "\t\t\t\t<td><a href=\".?edit=" . $book['id'] . "\">Edit</a></td>\n";
    echo "\t\t\t</tr>\n";
  }
?>
    </table>
      <table border=0>
        <tr><th colspan=2>New Book</th></tr>
        <tr><td>Title:</td><td><input type=text name=title size=25 maxlength=50></td></tr>
        <tr><td>Author:</td><td><!-- Pull down here with option of other to create new author --></td></tr>
        <tr><td align=top>Synopsis:</td><td><textarea cols=25 rows=5></textarea></td></tr>
        <tr><td>Release Date:</td><td><input type=text name=release_date size=25></td></tr>
        <tr><td>ISBN:</td><td><input type=text name=isbn size=15 maxlength=10></td></tr>
        <tr><td>Publisher:</td><td><!-- See author above --></td></tr>
        <tr><td>Price:</td><td><input type=text name=price size=15 maxlength=10></td></tr>
      </table>
  </div>
</body>
</html>
