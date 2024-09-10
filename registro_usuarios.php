<?php
// Incluir el archivo de conexión a la base de datos
include 'db.php'; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recuperar los datos del formulario
    $nombre = htmlspecialchars($_POST['nombre']);
    $email = htmlspecialchars($_POST['email']);
    $contraseña = htmlspecialchars($_POST['password']); 

    // Validar que los campos no estén vacíos (validación básica)
    if (!empty($nombre) && !empty($email) && !empty($contraseña)) {
        try {
            // Encriptar la contraseña antes de guardarla
            $contraseña_encriptada = password_hash($contraseña, PASSWORD_BCRYPT);

            // Preparar la inserción en la base de datos
            $sql = "INSERT INTO USUARIOS (nombre, email, contraseña) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$nombre, $email, $contraseña_encriptada]);

            echo "Usuario registrado exitosamente: $nombre, $email.";
        } catch (PDOException $e) {
            // Manejo de errores en caso de fallos en la inserción
            echo "Error al registrar el usuario: " . $e->getMessage();
        }
    } else {
        echo "Error: Todos los campos son obligatorios.";
    }
}
?>
