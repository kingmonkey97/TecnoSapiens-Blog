<?php
require('db.php'); 
session_start();

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
    <title>Contacto</title>
    <link rel="stylesheet" href="mono1.css">
</head>
<body>
    

    <h1 id="saludo">Estamos para resolver tus dudas, <?php echo htmlspecialchars($username); ?></h1>



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

    <div class="content">
    <h1>Contacto</h1>
    <p>Si tienes alguna pregunta, comentario o solicitud, no dudes en ponerte en contacto conmigo. Puedes utilizar el formulario de abajo o elegir uno de los siguientes métodos.</p>

    <div class="center-container">
        <section id="formulario-contacto" class="contac">
            <h2>Formulario falso</h2>
            <form action="" method="POST">
                <label for="nombre">Nombre:</label>
                <input type="text" id="nombre" name="nombre" required placeholder="Tu nombre completo">

                <label for="correo">Correo electrónico:</label>
                <input type="email" id="correo" name="correo" required placeholder="Tu correo electrónico">

                <label for="mensaje">Tu mensaje:</label>
                <textarea id="mensaje" name="mensaje" rows="5" required placeholder="Escribe tu mensaje aquí..."></textarea>

                <button type="submit">Enviar mensaje</button>
            </form>
        </section>
    </div>


</body>
</html>