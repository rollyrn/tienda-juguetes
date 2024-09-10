<?php
// Incluir el archivo de conexión a la base de datos
include 'db.php'; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recuperar los datos del formulario
    $nombre_juguete = htmlspecialchars($_POST['nombre_juguete']);
    $categoria = htmlspecialchars($_POST['categoria']);
    $precio = htmlspecialchars($_POST['precio']);

    // Validar que los campos no estén vacíos (validación básica)
    if (!empty($nombre_juguete) && !empty($categoria) && !empty($precio)) {
        try {
            // Preparar la inserción en la base de datos
            $sql = "INSERT INTO JUGUETES (nombre, descripcion, precio, cantidad) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            // Cantidad se pone como 0 por defecto, ajustar si hay campo específico para la cantidad
            $stmt->execute([$nombre_juguete, $categoria, $precio, 0]); // Se puede ajustar 'cantidad' según el formulario

            echo "Juguete registrado exitosamente: $nombre_juguete, Categoría: $categoria, Precio: $precio.";
        } catch (PDOException $e) {
            // Manejo de errores en caso de fallos en la inserción
            echo "Error al registrar el juguete: " . $e->getMessage();
        }
    } else {
        echo "Error: Todos los campos son obligatorios.";
    }
}
?>