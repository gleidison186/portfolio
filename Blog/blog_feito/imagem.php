<?php
require "db_functions.php";
$conn = connect_db();
$id = $_SESSION["user_id"];
$sql = "SELECT id,img FROM Login WHERE id = '$id'";
$result = mysqli_query($conn, $sql);
$user = mysqli_fetch_assoc($result);
$imagem = $user["img"];

?>
