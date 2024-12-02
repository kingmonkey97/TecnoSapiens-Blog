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
    <title>Preguntas Frecuentes</title>
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

        <h1>Preguntas Frecuentes</h1>

        <h2>Preguntas sobre el registro y la cuenta:</h2>

        <h3>¿Cómo me registro en el blog?</h3>
        <p>Para registrarte, haz clic en el botón de Registrarse en la página principal, completa el formulario con tu nombre y contraseña, y haz clic en registrarse.</p>

        <h3>¿Es obligatorio proporcionar un correo electrónico al registrarse?</h3>
        <p>No, actualmente no requerimos una verificación de correo electrónico para el registro.</p>

        <h3>¿Puedo registrarme usando mi cuenta de redes sociales?</h3>
        <p>No, el registro actualmente solo se realiza a través de un formulario estándar en el blog.</p>

        <h3>¿Cómo puedo cambiar mi nombre de usuario?</h3>
        <p>Actualmente, no se permite cambiar el nombre de usuario después de que te registres. Asegúrate de elegir un nombre que te guste al momento de registrarte.</p>

        <h3>¿Puedo cambiar mi contraseña después de registrarme?</h3>
        <p>Sí, puedes cambiar tu contraseña desde la página de Perfil, donde encontrarás la opción de Cambiar contraseña.</p>

        <h3>¿Cómo puedo eliminar mi cuenta en el blog?</h3>
        <p>Para eliminar tu cuenta, ponte en contacto con el soporte del blog, quien te proporcionará asistencia para cerrar tu cuenta.</p>

        <h2>Preguntas sobre publicaciones y comentarios:</h2>
        <h3>¿Cómo puedo publicar un artículo en el blog?</h3>
        <p>Haz clic en el botón Publicar en la parte superior de la página de inicio, completa el formulario con el contenido de tu publicación y haz clic en Enviar.</p>

        <h3>¿Qué tipo de contenido no está permitido en el blog?</h3>
        <p>No se permite contenido que sea ofensivo, ilegal, plagio o que infrinja los derechos de autor. Asegúrate de que tus publicaciones sean respetuosas y adecuadas para todos los usuarios.</p>

        <h3>¿Cómo puedo editar o eliminar una publicación que ya he subido?</h3>
        <p>En este momento, no es posible editar o eliminar publicaciones una vez que han sido publicadas. Si crees que una publicación infringe las normas, contacta con el soporte.</p>

        <h3>¿Puedo agregar imágenes o videos en mi publicación?</h3>
        <p>Sí, puedes agregar imágenes y videos en tu publicación siguiendo las pautas del blog sobre contenido multimedia.</p>

        <h3>¿Puedo comentar en las publicaciones de otros usuarios?</h3>
        <p>Sí, puedes comentar en cualquier publicación del blog, siempre y cuando sigas las normas de la comunidad.</p>

        <h3>¿Cómo puedo agregar un comentario en una publicación?</h3>
        <p>Para comentar, haz clic en el botón Comentar debajo de la publicación, escribe tu comentario en el formulario y haz clic en Enviar.</p>

        <h3>¿Puedo editar o borrar un comentario que he dejado?</h3>
        <p>No, una vez publicado un comentario, no puedes editarlo ni eliminarlo. Sin embargo, si hay un comentario inapropiado, puedes reportarlo a un moderador.</p>

        <h3>¿Puedo comentar de forma anónima?</h3>
        <p>No, los comentarios se vinculan a tu cuenta, por lo que no es posible comentar de forma anónima.</p>

        <h3>¿Puedo comentar en publicaciones antiguas?</h3>
        <p>Sí, puedes comentar en cualquier publicación, independientemente de cuán antigua sea.</p>

        <h2>Preguntas sobre la funcionalidad del sitio:</h2>
        <h3>¿Cómo puedo buscar contenido en el blog?</h3>
        <p>Usa el buscador ubicado en la parte superior de la página de inicio o en cualquier otra página para encontrar publicaciones relacionadas con el tema que te interese.</p>

        <h3>¿Puedo filtrar los resultados de búsqueda por tema o fecha?</h3>
        <p>No, actualmente no ofrecemos filtros avanzados, pero puedes usar palabras clave en el buscador para encontrar artículos específicos.</p>

        <h3>¿Puedo guardar mis publicaciones favoritas?</h3>
        <p>No, en este momento no hay una opción para guardar publicaciones como favoritas, pero puedes marcarlas en tu navegador.</p>

        <h3>¿Cómo puedo seguir a otros usuarios del blog?</h3>
        <p>Actualmente, no hay una opción para seguir a otros usuarios. Sin embargo, puedes interactuar con ellos a través de comentarios y publicaciones.</p>

        <h3>¿Puedo recibir notificaciones cuando alguien responda a mi comentario?</h3>
        <p>No, no ofrecemos notificaciones por respuesta a comentarios por el momento.</p>

        <h3>¿Cómo funciona el sistema de más comentados?</h3>
        <p>Las publicaciones que reciben más comentarios se muestran en la página Lo más comentado, permitiendo a los usuarios ver cuáles son las publicaciones más populares.</p>



        <h2>Preguntas sobre la política de contenido:</h2>
        
        <h3>¿Cuál es la política sobre contenido relacionado con software?</h3>
        <p>El blog permite contenido sobre software siempre que no infrinja los derechos de autor ni promueva prácticas ilegales.</p>

        <h3>¿Puedo publicar tutoriales o guías sobre tecnología en el blog?</h3>
        <p>Sí, puedes publicar tutoriales o guías relacionadas con tecnología, siempre que sigan las normas de contenido del blog.</p>

        <h3>¿Se permiten publicaciones relacionadas con el análisis de productos tecnológicos?</h3>
        <p>Sí, se pueden publicar análisis de productos tecnológicos, siempre que sean objetivos y respetuosos.</p>

        <h3>¿Puedo subir reseñas de software o aplicaciones en el blog?</h3>
        <p>Sí, puedes subir reseñas de software o aplicaciones, pero asegúrate de que sean originales y no infrinjan derechos de autor.</p>

        <h3>¿Se permiten publicaciones con contenido de código abierto?</h3>
        <p>Sí, el contenido de código abierto es bienvenido siempre que se dé crédito adecuado a los creadores originales.</p>

        <h3>¿Hay algún tipo de contenido que no sea aceptado en el blog, como material de piratería?</h3>
        <p>El blog no acepta contenido relacionado con la piratería, software ilegal o cualquier otro material que infrinja los derechos de autor.</p>

        
        
        <h2>Sobre nosotros:</h2>

        <h3>¿Qué tipo de contenido puedo encontrar en este blog?</h3>
        <p>En nuestro blog, podrás encontrar artículos, publicaciones y análisis sobre temas relacionados con la innovación, la tecnología y el software. Además, cubrimos novedades, tendencias y tutoriales prácticos sobre estos campos.</p>

        <h3>¿Puedo compartir mis propias publicaciones en el blog?</h3>
        <p>Sí, como usuario registrado, puedes compartir tus propias publicaciones en el blog, siempre y cuando cumplan con las normas de contenido del sitio.</p>

        <h3>¿Este blog tiene alguna política de contenido o moderación?</h3>
        <p>Sí, el blog cuenta con una política de contenido que regula las publicaciones para asegurar que sean relevantes, respetuosas y apropiadas. Las publicaciones que infringen nuestras políticas serán revisadas por un moderador y, si es necesario, eliminadas.</p>

        <h3>¿Puedo enviar un artículo para que sea publicado en el blog?</h3>
        <p>Sí, como usuario registrado, puedes enviar artículos para ser publicados. Asegúrate de que cumplan con las normas y estándares de calidad de nuestro blog.</p>

        <h3>¿Cuánto tiempo lleva publicar una nueva entrada en el blog?</h3>
        <p>El tiempo de publicación depende de varios factores, incluyendo la revisión por parte de los moderadores. Si tu publicación cumple con las normas, será publicada de inmediato.</p>

        <h3>¿Este blog tiene algún costo?</h3>
        <p>No, el blog es completamente gratuito tanto para leer como para publicar contenido.</p>

        <h3>¿Puedo cambiar el tema o diseño de mi cuenta en el blog?</h3>
        <p>Actualmente, no se pueden cambiar los temas o el diseño de las cuentas. El diseño del blog es estándar para todos los usuarios.</p>

        <h3>¿El contenido del blog se actualiza frecuentemente?</h3>
        <p>Sí, el contenido del blog se actualiza regularmente con nuevas publicaciones sobre tecnología, software y temas innovadores.</p>

        <h3>¿Dónde puedo encontrar las publicaciones más recientes?</h3>
        <p>Las publicaciones más recientes estarán disponibles en la página principal del blog, justo después del buscador.</p>

        <h3>¿Es este blog accesible desde dispositivos móviles?</h3>
        <p>Sí, el blog está optimizado para su visualización en dispositivos móviles, aunque suele haber algunas fallas.</p>




        <h2>Preguntas sobre el registro y la cuenta:</h2>
        <h3>¿Cómo me registro en el blog?</h3>
        <p>Para registrarte, haz clic en el botón de Registrarse en la página principal, completa el formulario con tu nombre y contraseña, y haz clic en registrarse.</p>

        <h3>¿Es obligatorio proporcionar un correo electrónico al registrarse?</h3>
        <p>No, actualmente no requerimos una verificación de correo electrónico para el registro.</p>

        <h3>¿Puedo registrarme usando mi cuenta de redes sociales?</h3>
        <p>No, el registro actualmente solo se realiza a través de un formulario estándar en el blog.</p>

        <h3>¿Cómo puedo cambiar mi nombre de usuario?</h3>
        <p>Actualmente, no se permite cambiar el nombre de usuario después de que te registres. Asegúrate de elegir un nombre que te guste al momento de registrarte.</p>

        <h3>¿Puedo cambiar mi contraseña después de registrarme?</h3>
        <p>Sí, puedes cambiar tu contraseña desde la página de Perfil, donde encontrarás la opción de Cambiar contraseña.</p>

        <h3>¿Cómo puedo eliminar mi cuenta en el blog?</h3>
        <p>Para eliminar tu cuenta, ponte en contacto con el soporte del blog, quien te proporcionará asistencia para cerrar tu cuenta.</p>

        <h2>Preguntas sobre publicaciones y comentarios:</h2>
        <h3>¿Cómo puedo publicar un artículo en el blog?</h3>
        <p>Haz clic en el botón Publicar en la parte superior de la página de inicio, completa el formulario con el contenido de tu publicación y haz clic en Enviar.</p>

        <h3>¿Qué tipo de contenido no está permitido en el blog?</h3>
        <p>No se permite contenido que sea ofensivo, ilegal, plagio o que infrinja los derechos de autor. Asegúrate de que tus publicaciones sean respetuosas y adecuadas para todos los usuarios.</p>

        <h3>¿Cómo puedo editar o eliminar una publicación que ya he subido?</h3>
        <p>En este momento, no es posible editar o eliminar publicaciones una vez que han sido publicadas. Si crees que una publicación infringe las normas, contacta con el soporte.</p>

        <h3>¿Puedo agregar imágenes o videos en mi publicación?</h3>
        <p>Sí, puedes agregar imágenes y videos en tu publicación siguiendo las pautas del blog sobre contenido multimedia.</p>

        <h3>¿Puedo comentar en las publicaciones de otros usuarios?</h3>
        <p>Sí, puedes comentar en cualquier publicación del blog, siempre y cuando sigas las normas de la comunidad.</p>

        <h3>¿Cómo puedo agregar un comentario en una publicación?</h3>
        <p>Para comentar, haz clic en el botón Comentar debajo de la publicación, escribe tu comentario en el formulario y haz clic en Enviar.</p>

        <h3>¿Puedo editar o borrar un comentario que he dejado?</h3>
        <p>No, una vez publicado un comentario, no puedes editarlo ni eliminarlo. Sin embargo, si hay un comentario inapropiado, puedes reportarlo a un moderador.</p>

        <h3>¿Puedo hacer comentarios anónimos?</h3>
        <p>No, los comentarios se vinculan a tu cuenta, por lo que no es posible comentar de forma anónima.</p>

        <h3>¿Puedo comentar en publicaciones antiguas?</h3>
        <p>Sí, puedes comentar en cualquier publicación, independientemente de cuán antigua sea.</p>

        <h2>Preguntas sobre la funcionalidad del sitio:</h2>
        <h3>¿Cómo puedo buscar contenido en el blog?</h3>
        <p>Usa el buscador ubicado en la parte superior de la página de inicio o en cualquier otra página para encontrar publicaciones relacionadas con el tema que te interese.</p>

        <h3>¿Puedo filtrar los resultados de búsqueda por tema o fecha?</h3>
        <p>No, actualmente no ofrecemos filtros avanzados, pero puedes usar palabras clave en el buscador para encontrar artículos específicos.</p>

        <h3>¿Puedo guardar mis publicaciones favoritas?</h3>
        <p>No, en este momento no hay una opción para guardar publicaciones como favoritas, pero puedes marcarlas en tu navegador.</p>

        <h3>¿Cómo puedo seguir a otros usuarios del blog?</h3>
        <p>Actualmente, no hay una opción para seguir a otros usuarios. Sin embargo, puedes interactuar con ellos a través de comentarios y publicaciones.</p>

        <h3>¿Puedo recibir notificaciones cuando alguien responda a mi comentario?</h3>
        <p>No, no ofrecemos notificaciones por respuesta a comentarios por el momento.</p>

        <h3>¿Cómo funciona el sistema de más comentados?</h3>
        <p>Las publicaciones que reciben más comentarios se muestran en la página Lo más comentado, permitiendo a los usuarios ver cuáles son las publicaciones más populares.</p>

        <h3>¿Cómo puedo ver las publicaciones más comentadas en el blog?</h3>
        <p>Haz clic en el botón Lo más comentado en el navegador para ver las publicaciones ordenadas por cantidad de comentarios.</p>

        <h3>¿Hay alguna limitación en el número de publicaciones que puedo hacer?</h3>
        <p>No, puedes hacer tantas publicaciones como desees, siempre que cumplan con las normas del blog.</p>
    </div>

</body>
</html>
