<?php
include 'db.php'; 
session_start();

// Verificar si el usuario está autenticado
if (!isset($_SESSION['username'])) {
    header("Location: login.php"); 
    exit();
}

$username = $_SESSION['username'];

$mensaje = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtener datos del formulario
    $password_actual = $_POST['password_actual'];
    $nueva_contrasena = $_POST['nueva_contrasena'];
    $confirmar_contrasena = $_POST['confirmar_contrasena'];

    try {
        // Consulta para obtener la contraseña actual del usuario
        $sql = "SELECT password FROM users WHERE username = :username";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':username', $username);
        $stmt->execute();

        // Verificar si se encontró el usuario
        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $password_hash = $row['password'];

            // Verificar la contraseña actual
            if (password_verify($password_actual, $password_hash)) {
                // Validar que la nueva contraseña y su confirmación coinciden
                if ($nueva_contrasena === $confirmar_contrasena) {
                    $nueva_contrasena_hash = password_hash($nueva_contrasena, PASSWORD_DEFAULT);

                    // Actualizar la contraseña en la base de datos
                    $update_sql = "UPDATE users SET password = :nueva_contrasena WHERE username = :username";
                    $update_stmt = $pdo->prepare($update_sql);
                    $update_stmt->bindParam(':nueva_contrasena', $nueva_contrasena_hash);
                    $update_stmt->bindParam(':username', $username);
                    $update_stmt->execute();

                    $mensaje = "Contraseña cambiada exitosamente.";
                } else {
                    $mensaje = "Las nuevas contraseñas no coinciden.";
                }
            } else {
                $mensaje = "La contraseña actual es incorrecta.";
            }
        } else {
            $mensaje = "Usuario no encontrado.";
        }
    } catch (PDOException $e) {
        $mensaje = "Error al actualizar la contraseña: " . $e->getMessage();
    }
}

// Redirigir a perfil con el mensaje
header("Location: perfil2.php?mensaje=" . urlencode($mensaje)); // Redirigir con el mensaje
exit();
?>
