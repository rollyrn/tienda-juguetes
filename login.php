<?php
// login.php
include 'db.php'; // Conexión a la base de datos

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = htmlspecialchars($_POST['email']);
    $password = htmlspecialchars($_POST['password']);

    // Consulta a la base de datos para validar las credenciales
    $stmt = $conn->prepare("SELECT * FROM USUARIOS WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['contraseña'])) {
        // Iniciar sesión si las credenciales son correctas
        $_SESSION['user_id'] = $user['ID'];
        $_SESSION['user_name'] = $user['nombre'];
        header('Location: carrito.php'); // Redirige a la página del carrito
        exit();
    } else {
        echo "<script>alert('Nombre de usuario o contraseña incorrectos.'); window.location.href='index.html';</script>";
    }
}
?>