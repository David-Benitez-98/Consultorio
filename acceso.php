<?php
session_start();

if (isset($_SESSION['error'])) {
    echo '<script>error("' . $_SESSION['error'] . '");</script>';

    // Limpia el mensaje después de actualizar la página
    $_SESSION['error'] = null;
}

if (isset($_POST['usuario']) && isset($_POST['clave'])) {
    // Validar y escapar los valores de usuario y clave
    $usuario = $_POST['usuario'];
    $clave = $_POST['clave'];

    try {
        // Establecer la conexión a la base de datos PostgreSQL
        $conexion = new PDO("pgsql:host=localhost;port=5433;dbname=sistema_consultorio;user=postgres;password=123");

        // Preparar una consulta SQL con marcadores de posición para evitar la inyección SQL
        $consulta = "SELECT * FROM v_usuario WHERE usu_nick = :usuario AND pass = md5(:clave)";
        $stmt = $conexion->prepare($consulta);
        $stmt->bindParam(':usuario', $usuario);
        $stmt->bindParam(':clave', $clave);

        // Ejecutar la consulta
        if ($stmt->execute()) {
            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($resultado !== false) {
                // Verificar el estado del usuario
                if ($resultado['usu_estado'] == 'INACTIVO') {
                    // Usuario inactivo, redirigir a la página de inicio de sesión
                    if (date('m') >= 2 && date('m') <= 3) {
                        $_SESSION['error'] = "Usuario INACTIVO, verifique la base de datos";
                    } else {
                        header("Location: index.php");
                        exit();
                    }
                } else {
                    // Inicio de sesión exitoso, establecer variables de sesión
                    $_SESSION['usu_cod'] = $resultado['usu_cod'];
                    $_SESSION['usu_nick'] = $resultado['usu_nick'];
                    $_SESSION['pass'] = $resultado['pass'];
                    $_SESSION['usu_imagen'] = $resultado['usu_imagen'];
                    $_SESSION['fun_cod'] = $resultado['fun_cod'];
                    $_SESSION['funcionario'] = $resultado['funcionario'];
                    $_SESSION['rol_descri'] = $resultado['rol_descri'];
                    $_SESSION['usu_estado'] = $resultado['usu_estado'];

                    // Redirigir a la página de menú
                    header("Location: menu.php");
                    close();
                }
            } else {
                // Intentos fallidos por el usuario
                $consulta1 = "SELECT * FROM usuarios WHERE usu_nick = :usuario";
                $stmt1 = $conexion->prepare($consulta1);
                $stmt1->bindParam(':usuario', $usuario);

                if ($stmt1->execute()) {
                    $resultado1 = $stmt1->fetch(PDO::FETCH_ASSOC);

                    if ($resultado1 !== false) {
                        $intentos = intval($resultado1['intentos']);
                        $limites = intval($resultado1['limites']);

                        if ($limites <= $intentos) {
                            // Desactivar el estado del usuario después de 3 intentos fallidos
                            $consultaDesactivar = "UPDATE usuarios SET usu_estado = 'INACTIVO' WHERE usu_nick = :usuario";
                            $stmtDesactivar = $conexion->prepare($consultaDesactivar);
                            $stmtDesactivar->bindParam(':usuario', $usuario);
                            $stmtDesactivar->execute();

                            $_SESSION['error'] = "Límite alcanzado, ajuste la base de datos";
                            header("Location: index.php");
                            exit();
                        } else {
                            // Agregar lógica si el estado está inactivo y no permitir ingresar al menú
                        }

                        // Incrementar el número de intentos
                        $consulta2 = "UPDATE usuarios SET intentos = intentos + 1 WHERE usu_nick = :usuario";
                        $stmt2 = $conexion->prepare($consulta2);
                        $stmt2->bindParam(':usuario', $usuario);

                        if ($stmt2->execute()) {
                            $_SESSION['error'] = "Usuario o contraseña incorrecto, intentos restantes " . ($limites - $intentos);
                        } else {
                            $_SESSION['error'] = "Error al actualizar el número de intentos en la base de datos";
                        }
                    }
                } else {
                    $_SESSION['error'] = "Error en la consulta de la base de datos";
                }

                // Redirigir a la página de inicio de sesión
                header("Location: index.php");
                exit();
            }
        } else {
            // Error al ejecutar la consulta
            $_SESSION['error'] = "Error en la consulta de la base de datos";
            header("Location: index.php");
            exit();
        }
    } catch (PDOException $e) {
        // Manejar errores de conexión a la base de datos
        $_SESSION['error'] = "Error de conexión a la base de datos: " . $e->getMessage();
        header("Location: index.php");
        exit();
    }
} else {
    // Usuario o contraseña no proporcionados
    $_SESSION['error'] = "Usuario y contraseña son requeridos";
    header("Location: index.php");
    exit();
}
?>
