<?php
require_once '../../config/database.php';
require_once '../../models/LoginModelo.php';

// Obtener los datos del formulario
$correo = $_REQUEST['correo'];
$clave = $_REQUEST['clave'];

// Crear una instancia del modelo
$loginModelo = new LoginModelo();

// Procesar el login
$usuario = $loginModelo->login($correo, $clave);

// Verificar si el usuario fue encontrado
if ($usuario) {
    // Iniciar la sesión
    session_start();

    // Generar las variables de sesión
    $_SESSION['activa'] = true;
    $_SESSION['usuario_id'] = $usuario['id_usuario']; // Suponiendo que el ID del usuario está en el array
    $_SESSION['correo'] = $usuario['correo']; // Suponiendo que el correo está en el array
    $_SESSION['nombre'] = $usuario['nombre'];
    $_SESSION['imagen'] = $usuario['imagen']; // Suponiendo que el nombre está en el array

    // Responder con éxito
    echo json_encode([
        'status' => 'success',
        'message' => 'Inicio de sesión exitoso.',
        'redirect' => '../views/home.php' // URL a la que redirigir
    ]);
} else {
    // Responder con error
    echo json_encode([
        'status' => 'error',
        'message' => 'Credenciales incorrectas.'
    ]);
}