<?php
require "db_credentials.php";

function connect_db(){
  global $servername, $username, $db_password, $dbname;
  $conn = mysqli_connect($servername, $username, "", $dbname);

  if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
  }
  return($conn);
}

function disconnect_db($conn){
  mysqli_close($conn);
}

function publicar(){
  $conn = connect_db();
  $sql = "SELECT * FROM posts;";
  $result = mysqli_query($conn, $sql);
	$posts = mysqli_fetch_all($result, MYSQLI_ASSOC);
	return $posts;
}

define('BASE_URL', 'http://localhost/Web/blog_feito/');
?>
