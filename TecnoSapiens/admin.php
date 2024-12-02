<?php
require "db.php";

session_start();

// Verificar si el usuario está autenticado y tiene el rol de administrador
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: inicio.php');
    exit();  
}


// Obtener todos los usuarios de la base de datos
$query = "
    SELECT u.id, u.username, u.role, u.created_at, COUNT(p.id) AS num_posts, COUNT(c.id) AS num_comments
    FROM users u
    LEFT JOIN post p ON u.username = p.author
    LEFT JOIN comment c ON u.username = c.author
    GROUP BY u.id
";
$statement = $pdo->query($query);
$users = $statement->fetchAll(PDO::FETCH_ASSOC);

// Obtener un solo usuario para editar
if (isset($_GET['edit'])) {
    $user_id = $_GET['edit'];
    $queryEdit = "SELECT * FROM users WHERE id = ?";
    $statementEdit = $pdo->prepare($queryEdit);
    $statementEdit->execute([$user_id]);
    $userToEdit = $statementEdit->fetch(PDO::FETCH_ASSOC);
}

// Actualizar usuario
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
    $username = $_POST['username'];
    $role = $_POST['role'];
    $user_id = $_GET['edit'];

    // Actualizar datos de usuario
    $updateQuery = "UPDATE users SET username = ?, role = ? WHERE id = ?";
    $updateStmt = $pdo->prepare($updateQuery);
    $updateStmt->execute([$username, $role, $user_id]);

     // Si el usuario es un "user", redirigir a inicio.php
     if ($role === 'user') {
        header('Location: inicio.php');
        exit();
    }

    // Si el usuario no es usuario, redirigir a admin.php 
    header('Location: admin.php');
    exit();
}

// Eliminar usuario
if (isset($_GET['delete'])) {
    $user_id = $_GET['delete'];

    // Obtener el nombre de usuario asociado al ID
    $queryGetUsername = "SELECT username FROM users WHERE id = ?";
    $stmtGetUsername = $pdo->prepare($queryGetUsername);
    $stmtGetUsername->execute([$user_id]);
    $username = $stmtGetUsername->fetchColumn();

    if ($username) {
        // Eliminar archivos subidos por el usuario
        $filesQuery = "SELECT media FROM post WHERE author = ?";
        $stmtFiles = $pdo->prepare($filesQuery);
        $stmtFiles->execute([$username]);
        $files = $stmtFiles->fetchAll(PDO::FETCH_ASSOC);
    
        foreach ($files as $file) {
            $filePath = __DIR__ . '/uploads/' . $file['media'];
            if (file_exists($filePath)) {
                unlink($filePath); // Elimina el archivo del servidor
            }
        }
    
        // Eliminar comentarios y publicaciones asociadas al usuario
        $deleteComments = "DELETE FROM comment WHERE author = ?";
        $stmtDeleteComments = $pdo->prepare($deleteComments);
        $stmtDeleteComments->execute([$username]);
    
        $deletePosts = "DELETE FROM post WHERE author = ?";
        $stmtDeletePosts = $pdo->prepare($deletePosts);
        $stmtDeletePosts->execute([$username]);
    
        // Finalmente, eliminar el usuario
        $deleteUser = "DELETE FROM users WHERE id = ?";
        $stmtDeleteUser = $pdo->prepare($deleteUser);
        $stmtDeleteUser->execute([$user_id]);
    }
    
    // Redirigir después de la eliminación
    header('Location: admin.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrar Usuarios</title>
    <link rel="stylesheet" href="mono1.css">
</head>
<body>
    <br><br><br><br>

    <div class="nav">
        <div class="logo">
            <header>
                <img src="TecnoSapiens.png" alt="Logo de TecnoSapiens" id="logo">
            </header>
            <h5 id="lema">Explorando el futuro, un byte a la vez.</h5>
        </div>
        <a href="inicio.php">Inicio</a>
        <a href="perfil.php">Perfil</a>
        <a href="masco.php">Lo más comentado</a>

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

    <div class="barra_admin">
        <h1>Panel de Administración de Usuarios</h1>
        <h2>Lista de Usuarios</h2>

        <table border="1">
            <thead>
                <tr>
                    <th>Nombre de Usuario</th>
                    <th>Tipo de Usuario</th>
                    <th>Publicaciones</th>
                    <th>Comentarios</th>
                    <th>Fecha de Registro</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($user['username']); ?></td>
                        <td><?php echo htmlspecialchars($user['role']); ?></td>
                        <td><?php echo $user['num_posts']; ?></td>
                        <td><?php echo $user['num_comments']; ?></td>
                        <td><?php echo $user['created_at']; ?></td>
                        <td>
                            <a href="admin.php?edit=<?php echo $user['id']; ?>">Editar</a> | 
                            <a href="admin.php?delete=<?php echo $user['id']; ?>" onclick="return confirm('¿Estás seguro de que deseas eliminar este usuario?');">Eliminar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        
        <br><br>

        <div class="admin-button">
            <a href="admin2.php" class="button-link">
                <button type="button">Registrar nuevo admin</button>
            </a>
        </div>

        <br><br>

        <?php if (isset($userToEdit)): ?>
            <h2>Editar Usuario: <?php echo htmlspecialchars($userToEdit['username']); ?></h2>
            <form action="admin.php?edit=<?php echo $userToEdit['id']; ?>" method="POST">
                <!-- Nombre de usuario, no editable -->
                <label for="username">Nombre de Usuario:</label>
                <input type="text" name="username" id="username" value="<?php echo htmlspecialchars($userToEdit['username']); ?>" readonly><br><br>

                <!-- Campo oculto para enviar el username -->
                <input type="hidden" name="username" value="<?php echo htmlspecialchars($userToEdit['username']); ?>">

                <!-- Selección de rol -->
                <label for="role">Rol:</label>
                <select name="role" id="role">
                    <option value="user" <?php echo ($userToEdit['role'] === 'user') ? 'selected' : ''; ?>>Usuario</option>
                    <option value="moderator" <?php echo ($userToEdit['role'] === 'moderator') ? 'selected' : ''; ?>>Moderador</option>
                    <option value="admin" <?php echo ($userToEdit['role'] === 'admin') ? 'selected' : ''; ?>>Administrador</option>
                </select><br><br>

                <button type="submit" name="update">Actualizar</button>
            </form>
            <br><br>
        <?php endif; ?>

    </div>

</body>
</html>
