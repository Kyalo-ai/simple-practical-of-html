<?php
$host = 'localhost';
$dbname = 'gfh_bank';
$username = 'root';
$password = ''; // Remember: default XAMPP is blank

try {
    // Attempt to connect
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // If it reaches here, the connection was successful
    echo "<h1 style='color: green;'>SUCCESS! Connected to the database 'gfh_bank' successfully.</h1>";
    
} catch (PDOException $e) {
    // If it fails, it will print the exact error
    echo "<h1 style='color: red;'>CONNECTION FAILED.</h1>";
    echo "<p><strong>Error Details:</strong> " . $e->getMessage() . "</p>";
}
?>