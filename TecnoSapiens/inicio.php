<?php
require 'db.php';
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

// Manejar la eliminación de publicaciones
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_post']) && $isAdminOrModerator) {
    $post_id = $_POST['post_id'];

    // Eliminar la publicación
    $query = "DELETE FROM post WHERE id = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$post_id]);

    $response = ['success' => false];

    if ($stmt->rowCount() > 0) {
        // Eliminar el archivo multimedia si existe
        $query = "SELECT media FROM post WHERE id = ?";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$post_id]);
        $post = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($post && $post['media']) {
            // Eliminar el archivo multimedia
            unlink($post['media']);
        }

        $response = ['success' => true];
    }

    // Responder en formato JSON
    echo json_encode($response);
    exit();
}


// Verificar si se ha enviado el formulario de búsqueda
$resultado_busqueda = [];
if (isset($_POST['buscar']) && !empty($_POST['criterio'])) {
    $criterio = $_POST['criterio'];
    
    // Consulta segura usando sentencias preparadas
    $sql = "SELECT * FROM post WHERE 
            id LIKE :criterio OR 
            author LIKE :criterio OR 
            title LIKE :criterio OR 
            content LIKE :criterio";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['criterio' => "%$criterio%"]);
    $resultado_busqueda = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Manejar creación de publicaciones
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['new_post'])) {
    if (!isset($_SESSION['username'])) {
        echo "Por favor, inicia sesión para crear una publicación.";
        exit();
    }

    $username = $_SESSION['username']; 
    $title = $_POST['title'];
    $content = $_POST['content'];
    $media = null;

    $author = $username; 

    // Manejar archivo subido
    if (isset($_FILES['media']) && $_FILES['media']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['media']['tmp_name'];
        $fileName = $_FILES['media']['name'];
        $fileSize = $_FILES['media']['size'];
        $fileType = $_FILES['media']['type'];

        // Verificar si el archivo es una imagen o video y tiene un tamaño válido
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'video/mp4', 'video/avi'];
        if (in_array($fileType, $allowedTypes) && $fileSize <= 5000000) { // Limitar a 5MB
            $uploadDir = 'uploads/';

            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true); // Crear la carpeta si no existe
            }

            // Crear un nombre único para evitar conflictos
            $fileDest = $uploadDir . uniqid() . '-' . basename($fileName);
            if (move_uploaded_file($fileTmpPath, $fileDest)) {
                $media = $fileDest; // Guardar la ruta del archivo subido
            } else {
                echo "Error al mover el archivo a la carpeta de destino.<br>";
            }
        } else {
            echo "Archivo no permitido o excede el tamaño máximo de 5MB.<br>";
        }
    } else {
        if ($_FILES['media']['error'] !== UPLOAD_ERR_OK) {
            echo "Error al cargar el archivo. Código: " . $_FILES['media']['error'] . "<br>";
        }
    }

    // Insertar la publicación en la base de datos con el nombre de usuario
    $query = "INSERT INTO post (author, title, content, media) VALUES (?, ?, ?, ?)";
    $stmt = $pdo->prepare($query);
    if ($stmt->execute([$author, $title, $content, $media])) {
        echo "Publicación creada exitosamente.<br>";
    } else {
        echo "Error al crear la publicación: " . implode(", ", $stmt->errorInfo()) . "<br>";
    }

    header('Location: inicio.php');
    exit();
}


// Manejar creación de comentarios
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['new_comment'])) {
    $post_id = $_POST['post_id'];
    $author = $_SESSION['username'];
    $content = $_POST['content'];

    // Insertar el comentario en la base de datos
    $query = "INSERT INTO comment (post_id, author, content) VALUES (?, ?, ?)";
    $stmt = $pdo->prepare($query);
    if ($stmt->execute([$post_id, $author, $content])) {
        echo "Comentario creado exitosamente.<br>";
    } else {
        echo "Error al crear el comentario: " . implode(", ", $stmt->errorInfo()) . "<br>";
    }

    header('Location: inicio.php');
    exit();
}


// Verificar si se ha enviado el formulario de búsqueda
$resultado_busqueda = []; 
if (isset($_POST['buscar']) && !empty($_POST['criterio'])) {
    $criterio = $_POST['criterio'];
    
    // Consulta segura usando sentencias preparadas
    $sql = "SELECT * FROM post WHERE 
            id LIKE :criterio OR 
            author LIKE :criterio OR 
            title LIKE :criterio OR 
            content LIKE :criterio";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['criterio' => "%$criterio%"]);
    $resultado_busqueda = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Obtener publicaciones
$query = "SELECT * FROM post ORDER BY date DESC";
$stmt = $pdo->query($query);
$posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog con Comentarios</title>
    <link rel="stylesheet" href="mono1.css">
</head>
<script>
    //borrar publicaciones 
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.delete-post').forEach(button => {
            button.addEventListener('click', function() {
                console.log("Botón de eliminar clickeado");

                const postId = this.dataset.postId; 
                const confirmation = confirm("¿Estás seguro de que deseas eliminar esta publicación?");
                
                if (confirmation) {
                    fetch('perfil.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded'
                        },
                        body: new URLSearchParams({
                            'delete_post': '1',
                            'post_id': postId
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert('La publicación ha sido eliminada con éxito.');
                            const postElement = button.closest('.post');
                            postElement.remove();
                        } else {
                            alert('Hubo un error al intentar eliminar la publicación.');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Hubo un error en la solicitud.');
                    });
                }
            });
        });
    });

    //mostrar/ocultar texto
    document.addEventListener("DOMContentLoaded", () => {
        const toggleButtons = document.querySelectorAll(".toggle-content");

        toggleButtons.forEach(button => {
            button.addEventListener("click", (e) => {
                const parent = e.target.closest(".post-content, .comment p"); // Aplica a posts y comentarios
                const shortContent = parent.querySelector(".short-content");
                const fullContent = parent.querySelector(".full-content");

                // Cambiar entre mostrar/ocultar
                if (fullContent.style.display === "none" || fullContent.style.display === "") {
                    fullContent.style.display = "inline";
                    shortContent.style.display = "none";
                    e.target.textContent = "Leer menos";
                } else {
                    fullContent.style.display = "none";
                    shortContent.style.display = "inline";
                    e.target.textContent = "Leer más";
                }
            });
        });
    });

</script>

<body>
    <br><br><br><br><br>
    <h1 id="saludo"><?= $welcomeMessage; ?></h1>



    <div class="nav">
        <div class="logo">
            <header>
            <img src="TecnoSapiens.png" alt="Logo de TecnoSapiens" id="logo">
            </header>
            <h5 id="lema">Explorando el futuro, un byte a la vez.</h6>
        </div>
        <a href="perfil.php">Perfil</a>
        <a href="masco.php">Lo mas comentado</a>
        <!-- Botón para mostrar el formulario -->
        <button class="btn-publicar" onclick="mostrarFormulario()">Publicar</button>


        <!-- Formulario de búsqueda fuera del menú desplegable -->
        <form class="butt" method="POST" action="" style="display:inline;">
            <input type="text" name="criterio" placeholder="Escribe el nombre, correo o teléfono">
            <button type="submit" name="buscar">Buscar</button>
        </form>

        <!-- Menú desplegable -->
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
    
    <div class="botonadmin">
        <!-- Mostrar el botón solo si el usuario es admin -->
        <?php if ($isAdminOrModerator): ?>
            <div class="admin-button">
                <form action="admin.php" method="get">
                    <button type="submit">Panel de administrador</button>
                </form>
            </div>
        <?php endif; ?>
    </div>
    
    <div class="formpost">
        <!-- Formulario para crear publicaciones -->
        <div class="post-form" id="formularioPublicar">
            <h2>Crear Nueva Publicación</h2>
            <!--<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" enctype="multipart/form-data">-->
            <form action="" method="POST" enctype="multipart/form-data">
                
                <input type="hidden" name="new_post" value="1">
                <label for="title">Título:</label><br>
                <input type="text" name="title" id="title" required><br><br>

                <label for="content">Contenido:</label><br>
                <textarea name="content" id="content" rows="5" required></textarea><br><br>

                <label for="media">Archivo Multimedia:</label><br>
                <input type="file" name="media" id="media" accept="image/*, video/*"><br><br>

                <input type="hidden" name="redirect_to" value="inicio.php">
                <button type="submit">Publicar</button>
            </form>
        </div>
    </div>

    <!-- Mostrar resultados de la búsqueda -->
    <div class="resultados_búsqueda">
        <?php if (!empty($resultado_busqueda)): ?>
            <h2 id="resultados">Resultados de la búsqueda</h2>
            <?php foreach ($resultado_busqueda as $post): ?>
                <div class="post2">
                    <!-- Título de la publicación -->
                    <h2><?= htmlspecialchars($post['title']); ?></h2>
                    <p><strong>Autor:</strong> <?= htmlspecialchars($post['author']); ?></p>
                    
                    <!-- Contenido del post con límite de caracteres -->
                    <p class="post-content">
                        <?php 
                            $content = htmlspecialchars($post['content']);
                            $shortContent = mb_substr($content, 0, 200); // Mostrar los primeros 200 caracteres
                        ?>
                        <span class="short-content"><?= nl2br($shortContent); ?>.. </span>
                        <span class="full-content" style="display: none;"><?= nl2br($content); ?></span>
                        <?php if (mb_strlen($content) > 200): ?>
                            <button class="toggle-content">Leer más</button>
                        <?php endif; ?>
                    </p>

                    <p><em>Publicado el: <?= $post['date']; ?></em></p>

                    <!-- Mostrar archivo multimedia -->
                    <?php if (!empty($post['media'])): ?>
                        <div class="media2">
                            <?php
                            $fileType = mime_content_type($post['media']);
                            if (strpos($fileType, 'image') !== false): ?>
                                <img src="<?= htmlspecialchars($post['media']); ?>" alt="Imagen" style="max-width: 100%; height: auto;">
                            <?php elseif (strpos($fileType, 'video') !== false): ?>
                                <video width="320" height="240" controls>
                                    <source src="<?= htmlspecialchars($post['media']); ?>" type="<?= htmlspecialchars($fileType); ?>">
                                    Tu navegador no soporta el elemento de video.
                                </video>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                    <br>

                    <!-- Botón de eliminar para admins/mods -->
                    <?php if ($isAdminOrModerator): ?>
                        <button class="delete-post" data-post-id="<?= $post['id']; ?>">Eliminar Publicación</button>
                    <?php endif; ?>

                    <!-- Botón para comentarios y número de comentarios -->
                    <div>
                        <button class="toggle-comments" data-post-id="<?= $post['id']; ?>">Comentar</button>
                        <?php
                            $commentQuery = "SELECT COUNT(*) AS comment_count FROM comment WHERE post_id = ?";
                            $stmt = $pdo->prepare($commentQuery);
                            $stmt->execute([$post['id']]);
                            $commentCount = $stmt->fetch(PDO::FETCH_ASSOC)['comment_count'];
                        ?>
                        <span class="comment-count"><?= $commentCount ?> Cmts.</span>
                    </div>

                    <!-- Sección de comentarios -->
                    <div class="comments-section" id="comments-<?= $post['id']; ?>" style="display: none;">
                        <?php
                        $commentQuery = "SELECT * FROM comment WHERE post_id = ? ORDER BY date ASC";
                        $stmt = $pdo->prepare($commentQuery);
                        $stmt->execute([$post['id']]);
                        $comments = $stmt->fetchAll(PDO::FETCH_ASSOC);
                        ?>
                        <?php if ($comments): ?>
                            <h3>Comentarios:</h3>
                            <?php foreach ($comments as $comment): ?>
                                <div class="comment">
                                    <p>
                                        <strong><?= htmlspecialchars($comment['author']); ?>:</strong>
                                        <?php 
                                            $commentContent = htmlspecialchars($comment['content']);
                                            $shortComment = mb_substr($commentContent, 0, 150); // Limitar a 150 caracteres
                                        ?>
                                        <span class="short-content"><?= nl2br($shortComment); ?>...</span>
                                        <span class="full-content" style="display: none;"><?= nl2br($commentContent); ?></span>
                                        <?php if (mb_strlen($commentContent) > 150): ?>
                                            <button class="toggle-content">Leer más</button>
                                        <?php endif; ?>
                                    </p>
                                    <p><em>Publicado el: <?= $comment['date']; ?></em></p>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p>No hay comentarios aún. ¡Sé el primero en comentar!</p>
                        <?php endif; ?>

                        <!-- Formulario para añadir comentarios -->
                        <form action="" method="POST">
                            <input type="hidden" name="new_comment" value="1">
                            <input type="hidden" name="post_id" value="<?= $post['id']; ?>">
                            <textarea name="content" rows="3" required></textarea><br><br>
                            <button type="submit">Comentar</button>
                        </form>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php elseif (isset($_POST['buscar'])): ?>
            <h4 id="no_result">No se encontraron resultados para tu búsqueda.</h4>
        <?php endif; ?>
    </div>


    <!--Mostrar publicaciones-->
    <div class="posts-container">
        <?php 
            // Consulta para obtener las publicaciones ordenadas por fecha y el número de comentarios
            $query = "
                SELECT p.*, COUNT(c.id) AS comment_count 
                FROM post p
                LEFT JOIN comment c ON p.id = c.post_id
                GROUP BY p.id
                ORDER BY p.date DESC"; // Ordenar por la fecha de publicación (más recientes primero)
            $stmt = $pdo->query($query);
            $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            if (!empty($posts)): ?>
            <?php foreach ($posts as $post): ?>
                <div class="post">
                    <h2><?= htmlspecialchars($post['title']); ?></h2>
                    <p><strong>Autor:</strong> <?= htmlspecialchars($post['author']); ?></p>

                    <!-- Contenido del post con límite de caracteres -->
                    <p class="post-content">
                        <?php 
                            $content = htmlspecialchars($post['content']);
                            $shortContent = mb_substr($content, 0, 200); // Mostrar los primeros 200 caracteres
                        ?>
                        <span class="short-content"><?= nl2br($shortContent); ?>.. </span>
                        <span class="full-content" style="display: none;"><?= nl2br($content); ?></span>
                        <?php if (mb_strlen($content) > 200): ?>
                            <button class="toggle-content">Leer más</button>
                        <?php endif; ?>
                    </p>

                    <p><em>Publicado el: <?= $post['date']; ?></em></p>

                    <!-- Mostrar archivo multimedia -->
                    <?php if (!empty($post['media'])): ?>
                        <div class="media">
                            <?php
                            $fileType = mime_content_type($post['media']);
                            if (strpos($fileType, 'image') !== false): ?>
                                <img src="<?= htmlspecialchars($post['media']); ?>" alt="Imagen" style="max-width: 100%; height: auto;">
                            <?php elseif (strpos($fileType, 'video') !== false): ?>
                                <video width="320" height="240" controls>
                                    <source src="<?= htmlspecialchars($post['media']); ?>" type="<?= htmlspecialchars($fileType); ?>">
                                    Tu navegador no soporta el elemento de video.
                                </video>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>

                    <!-- Botón de eliminar para admins/mods -->
                    <?php if ($isAdminOrModerator): ?>
                        <button class="delete-post" data-post-id="<?= $post['id']; ?>">Eliminar Publicación</button>
                    <?php endif; ?>

                    <!-- Botón para mostrar u ocultar comentarios -->
                    <div>
                        <button class="toggle-comments" data-post-id="<?= $post['id']; ?>">Comentar</button>
                        <span class="comment-count"><?= $post['comment_count']; ?> Cmts.</span>
                    </div>

                    <!-- Sección de comentarios -->
                    <div id="comments-<?= $post['id']; ?>" class="comments-section" style="display: none;">
                        <h3>Comentarios de: <?= htmlspecialchars($post['title']); ?></h3>
                        
                        <!-- Mostrar comentarios existentes -->
                        <?php
                        $commentQuery = "SELECT * FROM comment WHERE post_id = ? ORDER BY date ASC";
                        $stmt = $pdo->prepare($commentQuery);
                        $stmt->execute([$post['id']]);
                        $comments = $stmt->fetchAll(PDO::FETCH_ASSOC);
                        ?>
                        <?php if ($comments): ?>
                            <?php foreach ($comments as $comment): ?>
                                <div class="comment">
                                    <p>
                                        <strong><?= htmlspecialchars($comment['author']); ?>:</strong>
                                        <?= nl2br(htmlspecialchars($comment['content'])); ?>
                                    </p>
                                    <p><em>Publicado el: <?= $comment['date']; ?></em></p>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p>No hay comentarios aún. ¡Sé el primero en comentar!</p>
                        <?php endif; ?>

                        <!-- Formulario para agregar un comentario -->
                        <form action="" method="POST">
                            <input type="hidden" name="new_comment" value="1">
                            <input type="hidden" name="post_id" value="<?= $post['id']; ?>">
                            <textarea name="content" rows="3" required></textarea><br><br>
                            <button type="submit">Comentar</button>
                        </form>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No hay publicaciones aún.</p>
        <?php endif; ?>
    </div>


    <script>
        // Mostrar u ocultar la sección de comentarios
        document.addEventListener('DOMContentLoaded', () => {
            const buttons = document.querySelectorAll('.toggle-comments');
            buttons.forEach(button => {
                button.addEventListener('click', () => {
                    const postId = button.dataset.postId;
                    const commentsSection = document.getElementById('comments-' + postId);
                    if (commentsSection.style.display === 'none' || commentsSection.style.display === '') {
                        commentsSection.style.display = 'block'; 
                    } else {
                        commentsSection.style.display = 'none'; 
                    }
                });
            });
        });
    </script>


    <script>
        // Función para mostrar u ocultar el formulario post
        function mostrarFormulario() {
            var formulario = document.getElementById('formularioPublicar');
            if (formulario.style.display === 'none' || formulario.style.display === '') {
                formulario.style.display = 'block'; 
                localStorage.setItem('formularioVisible', 'true'); 
            } else {
                formulario.style.display = 'none'; 
                localStorage.setItem('formularioVisible', 'false');
            }
        }

        // Comprobar el estado del formulario al cargar la página
        window.onload = function() {
            var formulario = document.getElementById('formularioPublicar');
            var formularioVisible = localStorage.getItem('formularioVisible');
            if (formularioVisible === 'true') {
                formulario.style.display = 'block';
            } else {
                formulario.style.display = 'none';
            }
        };
    </script>

    


</body>
</html>