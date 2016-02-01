<?php
  require "../db_connection.php";

  // Create library adming table if it doesn't already exist.
  $sql = "CREATE TABLE IF NOT EXISTS library_admin (
          id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
          firstname VARCHAR(50),
          lastname VARCHAR(50),
          username VARCHAR(50) NOT NULL,
          password VARCHAR(50) NOT NULL,
          UNIQUE (username))";
  $stmt = $dbConn -> prepare($sql);
  $stmt -> execute();

  // Create table to keep track of successful log in attempts.
  $sql = "CREATE TABLE IF NOT EXISTS library_admin_login_attempts (
          library_admin_id INT NOT NULL,
          login_date DATETIME NOT NULL,
          FOREIGN KEY (library_admin_id) REFERENCES library_admin(id))";
  $stmt = $dbConn -> prepare($sql);
  $stmt -> execute();

  // Insert an admin account for each team member, as well as a 
  // general user if they don't already exist.
  $sql = "INSERT IGNORE INTO library_admin (firstname, lastname, username, password)
          VALUES (:firstname, :lastname, :username, :password)";
  $stmt = $dbConn -> prepare($sql);
  $stmt -> execute(array(":firstname" => "General", 
                         ":lastname" => "User", 
                         ":username" => "admin", 
                         ":password" => hash('sha1', 'password')));

  $sql = "INSERT IGNORE INTO library_admin (firstname, lastname, username, password)
          VALUES (:firstname, :lastname, :username, :password)";
  $stmt = $dbConn -> prepare($sql);
  $stmt -> execute(array(":firstname" => "Brittany", 
                         ":lastname" => "Mazza", 
                         ":username" => "bmazza", 
                         ":password" => hash('sha1', 'secret')));

  $sql = "INSERT IGNORE INTO library_admin (firstname, lastname, username, password)
          VALUES (:firstname, :lastname, :username, :password)";
  $stmt = $dbConn -> prepare($sql);
  $stmt -> execute(array(":firstname" => "John", 
                         ":lastname" => "Lester", 
                         ":username" => "jlester", 
                         ":password" => hash('sha1', 'secret')));

  $sql = "INSERT IGNORE INTO library_admin (firstname, lastname, username, password)
          VALUES (:firstname, :lastname, :username, :password)";
  $stmt = $dbConn -> prepare($sql);
  $stmt -> execute(array(":firstname" => "Ashley", 
                         ":lastname" => "Wallace", 
                         ":username" => "awallace", 
                         ":password" => hash('sha1', 'secret')));

  echo "Your admin table is created and four users have been inserted.";
?>
