<!-- carrito.php -->
<?php
session_start();
include 'db.php'; // Conexión a la base de datos

// Verificar si el usuario está autenticado
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Obtener los juguetes disponibles desde la base de datos
$juguetes = $conn->query("SELECT ID, nombre, precio FROM JUGUETES")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito de Compras</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <!-- Barra de Navegación -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="index.html">Tienda de Juguetes</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="index.html">Inicio</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="formularios.html">Registrar Productos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="carrito.php">Carrito</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="logout.php">Cerrar Sesión</a>
                </li>
            </ul>
        </div>
    </nav>

    <!-- Formulario para Gestionar el Carrito de Compras -->
    <div class="container mt-5">
        <h2>Gestionar Carrito de Compras</h2>
        <form action="procesar_carrito.php" method="post" onsubmit="return validarCarrito()">
            <div class="form-group">
                <label for="producto_id">Selecciona un Juguete:</label>
                <select class="form-control" id="producto_id" name="producto_id" required>
                    <?php foreach ($juguetes as $juguete): ?>
                        <option value="<?= $juguete['ID'] ?>"><?= $juguete['nombre'] ?> - $<?= number_format($juguete['precio'], 2) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="cantidad">Cantidad:</label>
                <input type="number" class="form-control" id="cantidad" name="cantidad" required min="1">
            </div>
            <button type="submit" class="btn btn-primary">Agregar al Carrito</button>
        </form>

        <!-- Mostrar el contenido del carrito -->
        <h3 class="mt-5">Tu Carrito</h3>
        <table class="table">
            <thead>
                <tr>
                    <th>Juguete</th>
                    <th>Cantidad</th>
                    <th>Precio Unitario</th>
                    <th>Monto Total</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Obtener los artículos del carrito del usuario actual
                $stmt = $conn->prepare("SELECT CARRITO.ID, JUGUETES.nombre, CARRITO.cantidad, JUGUETES.precio, CARRITO.monto_total FROM CARRITO 
                                        JOIN JUGUETES ON CARRITO.producto_id = JUGUETES.ID 
                                        WHERE CARRITO.usuario_id = ?");
                $stmt->execute([$_SESSION['user_id']]);
                $carrito_items = $stmt->fetchAll(PDO::FETCH_ASSOC);
                $total_a_pagar = 0;

                foreach ($carrito_items as $item):
                    $total_a_pagar += $item['monto_total'];
                ?>
                <tr>
                    <td><?= $item['nombre'] ?></td>
                    <td><?= $item['cantidad'] ?></td>
                    <td>$<?= number_format($item['precio'], 2) ?></td>
                    <td>$<?= number_format($item['monto_total'], 2) ?></td>
                    <td>
                        <form action="eliminar_carrito.php" method="post" style="display:inline;">
                            <input type="hidden" name="carrito_id" value="<?= $item['ID'] ?>">
                            <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <h4>Total a Pagar: $<?= number_format($total_a_pagar, 2) ?></h4>
    </div>

    <!-- Validaciones con JavaScript -->
    <script>
        function validarCarrito() {
            const cantidad = document.getElementById('cantidad').value;
            
            if (cantidad <= 0) {
                alert('La cantidad debe ser mayor a 0.');
                return false;
            }
            return true;
        }
    </script>

    <!-- Bootstrap JS, Popper.js, and jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>