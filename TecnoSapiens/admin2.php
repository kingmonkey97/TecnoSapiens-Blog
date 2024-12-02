<?php
require 'db.php'; 
session_start();

 //Verificar si el usuario está autenticado y es administrador
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: inicio.php');
    exit();
}

$message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtener datos del formulario
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = 'admin'; // Siempre asignamos el rol 'admin' 
    $created_at = date('Y-m-d H:i:s');
    $updated_at = date('Y-m-d H:i:s');

    // Validación básica
    if (empty($username) || empty($password)) {
        $message = "Por favor complete todos los campos.";
    } else {
        // Verificar si el usuario ya existe
        try {
            $sql = "SELECT COUNT(*) FROM users WHERE username = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$username]);
            $userCount = $stmt->fetchColumn();

            if ($userCount > 0) {
                $message = "El nombre de usuario ya está registrado.";
            } else {
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

                // Insertar en la base de datos
                $sql = "INSERT INTO users (username, password, role, created_at, updated_at) 
                        VALUES (?, ?, ?, ?, ?)";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([$username, $hashedPassword, $role, $created_at, $updated_at]);

                $message = "Administrador registrado con éxito.";
            }
        } catch (PDOException $e) {
            $message = "Error en la base de datos: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Administrador</title>
    <link rel="stylesheet" href="mono1.css">
</head>
<body>

    <div class="nav">
        <div class="logo">
            <header>
                <img src="TecnoSapiens.png" alt="Logo de TecnoSapiens" id="logo">
            </header>
            <h5 id="lema">Explorando el futuro, un byte a la vez.</h5>
        </div>
    </div>
    
    <br><br><br><br><br>

    <div class="center-container">
        <div class="register">
            <h2>Registrar Nuevo Administrador</h2>
            <form action="admin2.php" method="POST">
                <label for="username">Nombre de usuario:</label>
                <input type="text" id="username" name="username" required><br><br>
                
                <label for="password">Contraseña:</label>
                <input type="password" id="password" name="password" required><br><br>
                
                <button type="submit">Registrar Administrador</button>
            </form>
            <br>
            <a href="inicio.php">Volver a la página de inicio</a>
            <br>
            <a href="admin.php">Volver a la barra de administracion</a>

            <?php if (!empty($message)): ?>
                <div class="message">
                    <p><?php echo $message; ?></p>
                </div>
            <?php endif; ?>
        </div>
    </div>

</body>
</html>
