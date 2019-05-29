<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  require_once "credentials.php";

  // Create connection
  $conn = mysqli_connect($servername, $username, $password, $dbname);
  // Check connection
  if (!$conn) {
      die("Connection failed: " . mysqli_connect_error());
    }

    $sql = "INSERT INTO Teste (nome, email, senha)
    VALUES ('$nome', '$email', '$senha')";

    if (!mysqli_query($conn, $sql)) {
      echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

    mysqli_close($conn);
}
?>
