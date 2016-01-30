<?php
// **BM UPDATING NOW**
// updated by BM 30-Jan @ 1016
require '../db_connection.php'; // Open database connection.

function getBooks($sort) {
  global $dbConn;
  $sql = "SELECT books.id, 
            books.title, 
            books.synopsis, 
            books.price, 
            authors.name AS author 
          FROM books 
          LEFT JOIN authors 
          ON books.author_id = authors.id ";
  if (isset($_GET['sort']) && ($_GET['sort'] == 1)) {
    $sql .= "ORDER BY books.title;";
  } elseif (isset($_GET['sort']) && ($_GET['sort'] == 2)) {
    $sql .= "ORDER BY authors.name;";
  } elseif (isset($_GET['sort']) && ($_GET['sort'] == 3)) {
    $sql .= "ORDER BY books.price;";
  } else {
    $sql .= " ORDER BY books.id;";
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
  <title>Book Collection</title>
  <meta name="author" content="Team 6 - Bitsoft">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- Support John's directory structure -->
  <!-- <link rel="stylesheet" type="text/css" href="library.css">
  <link rel="shortcut icon" href="../media/assign4-favicon.ico">
  <style>
    body {
      background-image: url("../media/background-bookcase.jpg");
    }
  </style> -->

  <!-- Support Brittany's directory structure -->
  <link rel="stylesheet" type="text/css" href="library.css">
  <link rel="shortcut icon" href="favicon.ico">
  <style>
    body {
      background-image: url("background-library.jpg");
    }
  </style>

  <!-- Support Ashley's directory structure (Ashley -> Update as needed) -->
  <!-- <link rel="stylesheet" type="text/css" href="library.css">
  <link rel="shortcut icon" href="favicon.ico">
  <style>
    body {
      background-image: url("background-library.jpg");
    }
  </style> -->

</head>

<body>
  <div class="content">
	<h1>BITsoft Book Collection</h1>
  <table border=0 width=1000>
	<tr>
        <th onClick="javascript:location.href='?sort=0'">ID<img src="../media/down.png"></th>
		<th width=200 onClick="javascript:location.href='?sort=1'">Title<img src="../media/down.png"></th>
        <th width=200 onClick="javascript:location.href='?sort=2'">Author<img src="../media/down.png"></th>
        <th>Synopsis</th>
        <th width=50 onClick="javascript:location.href='?sort=3'">Price<img src="../media/down.png"></th>
        <th> </th>
      </tr>
<?php
  $bookList = getBooks();
  foreach ($bookList as $book) {
    echo "\t\t\t<tr onclick=\"document.getElementById('light').style.display='block';document.getElementById('fade').style.display='block'\">\n";
    echo "\t\t\t\t<td><i>" . $book['id'] . "</i></td>\n";
    echo "\t\t\t\t<td><i>" . $book['title'] . "</i></td>\n";
    echo "\t\t\t\t<td>" . $book['author'] . "</td>\n";
    echo "\t\t\t\t<td>" . substr($book['synopsis'], 0, 125) . "...</td>\n"; // Add an onClick pop-up that shows full synopsis & details
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
  <div id="light" class="white_content">
	<table border=0>
		<th colspan=2 align=right onclick = "document.getElementById('light').style.display='none';document.getElementById('fade').style.display='none'">Close</th>
		<tr><td>Title</td><td rowspan=5>picOfCover</td></tr>
		<tr><td>ISBN: isbn</td></tr>
		<tr><td>by: author</td></tr>
		<tr><td>Date: release_date</td></tr>
		<tr><td>Pub: publisher</td></tr>
		<tr><td colspan=2>Synopsis: synopsis goes here asdf asdf asdf asdf asdf asdf asdf asdf asdf asdf asdf asdf asdf asdf asdf asdf asdf asdf asdf asdf asdf asdf asdf asdf asdf asdf asdf </td></tr>
	</table>
	</div>
  <div id="fade" class="black_overlay"></div>
</body>
</html>
