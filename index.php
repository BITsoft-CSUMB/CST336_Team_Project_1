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
  <link rel="shortcut icon" href="../media/assign4-favicon.ico">
  <style>
    body {
      background-image: url("../media/background-bookcase.jpg");
    }
  </style>

  <!-- Support Brittany's directory structure -->
  <!--<link rel="shortcut icon" href="favicon.ico">
  <style>
    body {
      background-image: url("background-bookcase.jpg");
    }
  </style>-->

  <!-- Support Ashley's directory structure (Ashley -> Update as needed) -->
  <!--<link rel="shortcut icon" href="favicon.ico">
  <style>
    body {
      background-image: url("background-bookcase.jpg");
    }
  </style>-->
  
  <style>
  /* Color Palette:
     #334139 -> Lighter Green    #1E2D24 -> Dark Green
     #E6E8E6 -> Off White        #FFE0B5 -> Light Tan
     #433F6B -> Indigo           */

  h1 {
    color: #1E2D24;
    text-align: center;
	text-shadow: -2px 2px #888888;
  }
  table {
    margin: auto;
    background-color: #E6E8E6;
  }
  tr:hover {
    background-color: #FFE0B5;
  }
  th {
    background-color: #433F6B;
	color: white;
	text-shadow: -1px 1px #888888;
  }
  td {
    border-bottom: 1px solid #ddd;
    padding: 5px;
  }
  a {
	  color: black;
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
  .black_overlay {
    display: none;
    position: absolute;
    top: 0%;
    left: 0%;
    width: 100%;
    height: 100%;
    background-color: black;
    z-index:1001;
    -moz-opacity: 0.8;
    opacity:.80;
    filter: alpha(opacity=80);
  }
  .white_content {
    display: none;
    position: absolute;
    top: 25%;
    left: 25%;
    width: 50%;
    height: 50%;
    padding: 5px;
    border: 5px solid #433F6B;
    background-color: #E6E8E6;
    z-index:1002;
    overflow: auto;
  }
  </style>
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
