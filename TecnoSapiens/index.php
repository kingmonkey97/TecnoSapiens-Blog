<?php
require 'db.php'; 

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

// Obtener publicaciones recientes
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
    //mostrar/ocultar texto
    document.addEventListener("DOMContentLoaded", () => {
        const toggleButtons = document.querySelectorAll(".toggle-content");

        toggleButtons.forEach(button => {
            button.addEventListener("click", (e) => {
                const parent = e.target.closest(".post-content, .comment p");
                const shortContent = parent.querySelector(".short-content");
                const fullContent = parent.querySelector(".full-content");

                if (fullContent.style.display === "none") {
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
    
    <div class="nav">
        <div class="logo">
            <header>
            <img src="TecnoSapiens.png" alt="Logo de TecnoSapiens" id="logo">
            </header>
            <h5 id="lema">Explorando el futuro, un byte a la vez.</h6>
        </div>
    </div>

    <br><br><br><br><br>

    <div class="index1">
        <div class="login_register">
            <form action="register.php" method="POST" style="display:inline;">
                <input type="hidden" name="button_login">
                <button type="submit" name="button_login2">¿No tienes cuenta? Registrarse</button>
            </form>

            <form action="login.php" method="POST" style="display:inline;">
                <input type="hidden" name="button_login">
                <button type="submit" name="button_login2">¿Ya tienes una cuenta? Iniciar sesión</button>
            </form>
        </div>

        <form method="POST" action="">
            <input type="text" name="criterio" placeholder="Escribe el nombre, correo o teléfono">
            <button type="submit" name="buscar">Buscar</button>
        </form>
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
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No hay publicaciones aún.</p>
        <?php endif; ?>
    </div>


    <script>
        // Mostrar u ocultar la sección de comentarios
        const buttons = document.querySelectorAll('.toggle-comments');
        buttons.forEach(button => {
            button.addEventListener('click', () => {
                const postId = button.dataset.postId;
                const commentsSection = document.getElementById('comments-' + postId);
                commentsSection.style.display = (commentsSection.style.display === 'none') ? 'block' : 'none';
            });
        });
    </script>

</body>
</html>