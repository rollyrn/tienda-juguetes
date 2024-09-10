<?php
// procesar_carrito.php
include 'db.php'; // Conexión a la base de datos
session_start();

// Verificar si el usuario está autenticado
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recuperar los datos del formulario
    $producto_id = htmlspecialchars($_POST['producto_id']);
    $cantidad = htmlspecialchars($_POST['cantidad']);
    $user_id = $_SESSION['user_id'];

    // Validar que los campos no estén vacíos
    if (!empty($producto_id) && !empty($cantidad) && $cantidad > 0) {
        // Consultar el precio del producto
        $stmt = $conn->prepare("SELECT precio FROM JUGUETES WHERE ID = ?");
        $stmt->execute([$producto_id]);
        $producto = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($producto) {
            // Calcular el monto total
            $precio = $producto['precio'];
            $monto_total = $precio * $cantidad;

            // Insertar en la tabla CARRITO
            $stmt = $conn->prepare("INSERT INTO CARRITO (usuario_id, producto_id, cantidad, monto_total) VALUES (?, ?, ?, ?)");
            if ($stmt->execute([$user_id, $producto_id, $cantidad, $monto_total])) {
                echo "Producto agregado al carrito exitosamente.";
                // Redirigir al carrito o a otra página relevante
                header('Location: carrito.php');
                exit();
            } else {
                echo "Error: No se pudo agregar el producto al carrito.";
            }
        } else {
            echo "Error: El producto no existe.";
        }
    } else {
        echo "Error: Todos los campos son obligatorios y la cantidad debe ser mayor a 0.";
    }
}
?>