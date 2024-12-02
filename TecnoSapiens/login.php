<?php
require 'db.php'; 
session_start();

// Manejar el inicio de sesión cuando se recibe un POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Verificar si el usuario existe en la base de datos
    $query = "SELECT * FROM users WHERE username = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Si el usuario existe y la contraseña es correcta
    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];

        header('Location: inicio.php');
        exit();
    } else {
        $error = "Credenciales incorrectas.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar sesión</title>
    <link rel="stylesheet" href="mono1.css">
</head>
<body>

    <br><br><br><br><br><br>

    <div class="nav">
        <div class="logo">
            <header>
            <img src="TecnoSapiens.png" alt="Logo de TecnoSapiens" id="logo">
            </header>
            <h5 id="lema">Explorando el futuro, un byte a la vez.</h6>
        </div>
    </div>

    <div class="center-container">
        <div class="register">
            <h1>Iniciar sesión</h1>

            <form action="login.php" method="POST">
                <label for="username">Nombre de usuario:</label><br>
                <input type="text" name="username" id="username" required><br><br>

                <label for="password">Contraseña:</label><br>
                <input type="password" name="password" id="password" required><br><br>

                <button type="submit" name="login">Iniciar sesión</button>
            </form>
            <p>¿No tienes cuenta? <a href="register.php">Registrarse</a></p>
            
            <div style="text-align: center;">
                <a href="index.php">Volver a la página de inicio</a>
            </div>



            <?php
            if (isset($error)) {
                echo "<p style='color: red;'>$error</p>";
            }
            ?>
        </div>
    </div>
</body>
</html>
