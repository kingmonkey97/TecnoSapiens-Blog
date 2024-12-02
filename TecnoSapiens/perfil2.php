<?php
require('db.php');
session_start();

// Si no estás autenticado, redirige al login
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Verificar si el usuario es admin o moderador
$isAdminOrModerator = $_SESSION['role'] == 'admin' || $_SESSION['role'] == 'moderator';

// Obtener el nombre de usuario y el rol de la sesión
$username = $_SESSION['username'];
$role = $_SESSION['role'];

// Determinar el mensaje de bienvenida basado en el rol
if ($role == 'admin') {
    $welcomeMessage = "Bienvenido administrador, $username";
} elseif ($role == 'moderator') {
    $welcomeMessage = "Bienvenido moderador, $username";
} else {
    $welcomeMessage = "Bienvenido, $username";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Perfil de Usuario</title>
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
        <a href="inicio.php">Inicio</a>
        <a href="perfil.php">Perfil</a>
        <a href="masco.php">Lo mas comentado</a>
        <button class="btn-publicar" onclick="mostrarFormulario()">Publicar</button>

        <form class="butt" method="POST" action="" style="display:inline;">
            <input type="text" name="criterio" placeholder="Escribe el nombre, correo o teléfono">
            <button type="submit" name="buscar">Buscar</button>
        </form>

        <div class="dropdown">
            <button class="dropbtn">Más opciones</button>
            <div class="dropdown-content">
                <a href="faq.php">Preguntas Frecuentes</a>
                <a href="contacto.php">Contacto</a>
                <a href="politicas.php">Políticas</a>
                <a href="logout.php">Cerrar sesión</a>
            </div>
        </div>
    </div>

    <div class="center-container">
        <div class="register">
            <h1>Aqui puedes cambiar tu contraceña, <?php echo htmlspecialchars($username); ?></h1>

            <form action="cambiar_contrasena.php" method="post">
                <label for="password_actual">Contraseña actual:</label>
                <input type="password" id="password_actual" name="password_actual" required>
                <br>

                <label for="nueva_contrasena">Nueva contraseña:</label>
                <input type="password" id="nueva_contrasena" name="nueva_contrasena" required>
                <br>

                <label for="confirmar_contrasena">Confirmar nueva contraseña:</label>
                <input type="password" id="confirmar_contrasena" name="confirmar_contrasena" required>
                <br>

                <input type="submit" value="Cambiar Contraseña">
                <br>
                <?php if (isset($_GET['mensaje'])): ?>
                    <div style="color: red;"><?php echo htmlspecialchars($_GET['mensaje']); ?></div>
                <?php endif; ?>
            </form>
        </div>

    </div>
</body>
</html>
