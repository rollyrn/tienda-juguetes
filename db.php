<?php
$servername = "localhost"; // Servidor de MySQL
$username = "root";        // Usuario de MySQL
$password = "*Tic67015";   // Contraseña de MySQL
$dbname = "TOYS";          // Nombre de la base de datos

try {
    // Crear conexión usando PDO
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // Establecer el modo de error a excepciones
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Conexión exitosa";
} catch(PDOException $e) {
    echo "Error de conexión: " . $e->getMessage();
}
?>