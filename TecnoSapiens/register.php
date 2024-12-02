<?php
require 'db.php';

// Habilitar errores para depuración
error_reporting(E_ALL);
ini_set('display_errors', 1);

$message = '';

// Manejar el registro
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['register'])) {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Encriptar la contraseña

    // Verificar si el nombre de usuario ya existe
    $query = "SELECT * FROM users WHERE username = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$username]);

    // Verifica si el nombre de usuario ya está en uso
    if ($stmt->rowCount() > 0) {
        $message = "Este nombre de usuario ya está en uso.";
    } else {
        // Insertar el nuevo usuario en la base de datos
        $query = "INSERT INTO users (username, password) VALUES (?, ?)";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$username, $password]);

        // Verifica si la inserción fue exitosa
        if ($stmt->rowCount() > 0) {
            // Si la inserción fue exitosa, redirigir
            header('Location: login.php');
            exit();
        } else {
            $message = "Hubo un error al registrar el usuario.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
    <link rel="stylesheet" href="mono1.css">
</head>
<body>
    
    <div class="nav">
        <div class="logo">
            <header>
            <img src="TecnoSapiens.png" alt="Logo de TecnoSapiens" id="logo">
            </header>
            <h5 id="lema">Explorando el futuro, un byte a la vez.</h6>
        </div>
    </div>
    <br><br><br><br><br><br>
    <div class="center-container">
        <div class="register">
            <h1>Crear una Cuenta</h1>
            <form action="register2.php" method="POST">
                <label for="username">Nombre de usuario:</label><br>
                <input type="text" name="username" id="username" required><br><br>

                <label for="password">Contraseña:</label><br>
                <input type="password" name="password" id="password" required><br><br>

                <button type="submit" name="register">Registrarse</button>
            </form>
            <p>¿Ya tienes una cuenta? <a href="login.php">Iniciar sesión</a></p>

            <div style="text-align: center;">
                <a href="index.php">Volver a la página de inicio</a>
            </div>


            <?php
            if ($message) {
                echo "<p style='color: red;'>$message</p>";
            }
            ?>
        </div>
    </div>
</body>
</html>
