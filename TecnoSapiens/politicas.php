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
    <title>Políticas</title>
    <link rel="stylesheet" href="mono1.css">
</head>
<body>

    <br><br><br><br><br>


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
        <h1>Políticas del Blog</h1>

        <h2>Política de Contenido</h2>
        <h3>Contenido Aceptable</h3>
        <p>Este blog está diseñado para compartir contenido relacionado con el ámbito tecnológico, tutoriales, reseñas de software y temas educativos. Se permiten publicaciones que fomenten el aprendizaje y el desarrollo en estas áreas.</p>

        <h3>Contenido Prohibido</h3>
        <p>No se permite la publicación de contenido que promueva actividades ilegales, odiosas, discriminatorias, difamatorias o violentas. Esto incluye contenido relacionado con la piratería, la incitación al odio, el acoso o el plagio.</p>

        <h3>Derechos de Autor</h3>
        <p>Los usuarios deben garantizar que el contenido que publiquen no infrinja los derechos de autor. El uso de material con licencia debe ser debidamente atribuido al autor original. El blog se reserva el derecho de eliminar cualquier contenido que infrinja estos derechos.</p>

        <h2>Política de Registro y Uso de Cuenta</h2>
        <h3>Registro de Usuarios</h3>
        <p>El registro en el blog es necesario para participar activamente, como publicar artículos o comentar. Los usuarios deberán proporcionar un nombre de usuario único y, opcionalmente, un correo electrónico para recuperar la contraseña.</p>

        <h3>Seguridad de la Cuenta</h3>
        <p>Los usuarios son responsables de mantener la confidencialidad de sus credenciales de acceso y notificar al equipo del blog en caso de sospecha de uso no autorizado de su cuenta.</p>

        <h3>Política de Contraseñas</h3>
        <p>Es recomendable usar contraseñas seguras y cambiarlas regularmente para proteger la seguridad de la cuenta. Los usuarios pueden cambiar su contraseña en la sección de configuración de su perfil.</p>

        <h2>Política de Publicaciones y Comentarios</h2>
        <h3>Publicación de Artículos</h3>
        <p>Los usuarios pueden crear y publicar artículos sobre los temas mencionados en la política de contenido. Cada artículo debe ser original y estar redactado de forma clara y educativa.</p>

        <h3>Edición y Eliminación de Artículos</h3>
        <p>Una vez publicada una entrada, no podrá ser editada ni eliminada por el autor. Si se detecta algún error o contenido inapropiado, se podrá solicitar la eliminación al equipo del blog.</p>

        <h3>Comentarios en las Publicaciones</h3>
        <p>Los usuarios pueden dejar comentarios en las publicaciones, siempre que sean respetuosos y constructivos. Los comentarios que sean ofensivos, spam o inapropiados serán eliminados sin previo aviso.</p>

        <h3>Comportamiento en los Comentarios</h3>
        <p>Los comentarios que inciten al odio, violencia, acoso o cualquier forma de discriminación serán eliminados y pueden llevar al bloqueo del usuario.</p>

        <h2>Política de Privacidad</h2>
        <h3>Recopilación de Datos</h3>
        <p>El blog recopila información personal solo cuando es necesaria para el funcionamiento de la plataforma, como el registro de usuarios y la administración de cuentas.</p>

        <h3>Uso de Cookies</h3>
        <p>Este blog utiliza cookies para mejorar la experiencia del usuario y proporcionar contenido personalizado. Al usar el blog, los usuarios aceptan el uso de cookies.</p>

        <h3>Protección de la Información Personal</h3>
        <p>La información personal de los usuarios será tratada con la máxima confidencialidad y no se compartirá con terceros sin el consentimiento explícito del usuario, salvo en casos excepcionales donde sea requerido por la ley.</p>

        <h2>Política de Moderación</h2>
        <h3>Control de Contenido Inapropiado</h3>
        <p>El blog tiene un sistema de moderación para garantizar que el contenido y los comentarios sean apropiados. Los administradores del blog pueden eliminar o modificar publicaciones y comentarios que no cumplan con las políticas del sitio.</p>

        <h3>Bloqueo de Cuentas</h3>
        <p>Los usuarios que violen repetidamente las políticas del blog, o que participen en actividades como el acoso, la publicidad no solicitada o la difusión de contenido ilegal, pueden ser bloqueados permanentemente del sitio.</p>

        <h2>Política de Propiedad Intelectual</h2>
        <h3>Derechos de Propiedad del Contenido</h3>
        <p>El contenido publicado en este blog sigue siendo propiedad del autor que lo crea, pero al publicarlo, el autor otorga al blog una licencia para usarlo en la plataforma.</p>

        <h3>Uso del Contenido del Blog</h3>
        <p>Los usuarios pueden compartir y utilizar el contenido del blog solo para fines educativos y no comerciales, siempre que se dé el crédito adecuado al autor. No se permite el uso comercial sin autorización previa.</p>

        <h2>Política de Modificaciones</h2>
        <h3>Actualización de Políticas</h3>
        <p>Estas políticas pueden ser actualizadas en cualquier momento para adaptarse a cambios legales o mejoras en el funcionamiento del blog. Los usuarios serán notificados de cualquier cambio significativo.</p>

        <h3>Aceptar Cambios</h3>
        <p>Al continuar utilizando el blog después de la publicación de las actualizaciones de estas políticas, se considera que el usuario acepta los nuevos términos y condiciones.</p>

        <h2>Política de Publicidad y Promociones</h2>
        <h3>Publicidad en el Blog</h3>
        <p>El blog se reserva el derecho de incluir anuncios publicitarios en el sitio. Los usuarios no podrán insertar anuncios no autorizados en sus publicaciones o comentarios.</p>

        <h3>Promociones y Colaboraciones</h3>
        <p>Cualquier colaboración comercial o patrocinio será claramente etiquetado. Los usuarios deben asegurarse de que cualquier promoción realizada cumpla con las políticas de contenido y no sea engañosa.</p>
    </div>

</body>
</html>
