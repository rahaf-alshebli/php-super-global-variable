<?php 
    // starting session
    session_start();
    
    $conn = mysqli_connect("localhost", "root", "", "adv");
?>



<!-- $host ="localhost";
$databaseName ="dbtask";
$username ="root";
$password ="";

$dsn ="mysql:host=$host;dbname=$databaseName";



try {
    $databaseConnection = new PDO($dsn, $username, $password);
        echo "Connection successfully!";
} catch (PDOException $error) {
    echo $error;
} -->