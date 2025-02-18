<?php
require_once '../../config/database.php';
require_once '../../models/UsuariosModelo.php';

$usuarioModelo = new UsuariosModelo();

// Habilitar la visualización de errores (para desarrollo)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (isset($_REQUEST['nombre']) && isset($_REQUEST['correo']) && isset($_REQUEST['clave'])) {
    $nombre = $_REQUEST['nombre'];
    $correo = $_REQUEST['correo'];
    $clave = $_REQUEST['clave'];

    $insert = $usuarioModelo->agregar_usuario($nombre, $correo, $clave);

    if ($insert) {
        echo json_encode([
            'status' => 'success',
            'message' => 'Registro exitoso.'
        ]);
        exit; // Asegúrate de que no haya más salida
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'Error al registrarte. Inténtalo de nuevo.'
        ]);
        exit;
    }
}

if (isset($_REQUEST['correo_recupera'])) {
    $correo = $_REQUEST['correo_recupera'];
    $usuario = $usuarioModelo->verificar_correo($correo);

    if ($usuario) {
        echo json_encode([
            'status' => 'success',
            'message' => 'Correo verificado.',
            'nombre' => $usuario['nombre'], // Asegúrate de que 'nombre' existe en el resultado
            'correo' => $usuario['correo'],
            'id_usuario' => $usuario['id_usuario']  // Asegúrate de que 'correo' existe en el resultado
        ]);
        exit;
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'Error al verificar el correo.'
        ]);
        exit;
    }
}

if (isset($_REQUEST['usuario_id']) && isset($_REQUEST['clave_nueva']) && isset($_REQUEST['confirma_nueva_clave'])) {
    $usuario = $_REQUEST['usuario_id'];
    $clave = $_REQUEST['clave_nueva'];
    $confirma_clave = $_REQUEST['confirma_nueva_clave'];

    if ($clave == $confirma_clave) {
        $claveHash = password_hash($clave, PASSWORD_DEFAULT);
        $contrasena_update = $usuarioModelo->actualizar_contrasena($usuario, $claveHash);
    }

    if ($contrasena_update) {
        echo json_encode([
            'status' => 'success',
            'message' => 'Contraseña cambiada.' // Asegúrate de que 'correo' existe en el resultado
        ]);
        exit;
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'Error al cambiar el pass.'
        ]);
        exit;
    }
}

if (isset($_REQUEST['usuario_delete_id'])) {
    $usuario_id = $_REQUEST['usuario_delete_id'];

    $delete = $usuarioModelo->eliminar_usuario($usuario_id);

    if ($delete) {

        echo json_encode([
            'status' => 'success',
            'message' => 'Usuario eliminado.' // Asegúrate de que 'correo' existe en el resultado
        ]);
        exit;
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'Error al eliminar el usuario.'
        ]);
        exit;
    }
}

if (isset($_REQUEST['usuario_id']) && isset($_REQUEST['nombre_update']) && isset($_REQUEST['correo_update']) && isset($_REQUEST['perfil_update'])) {
    $usuario_id = $_REQUEST['usuario_id'];
    $nombre = $_REQUEST['nombre_update'];
    $correo = $_REQUEST['correo_update'];
    $perfil = $_REQUEST['perfil_update'];

    // Llamar al modelo para actualizar el usuario
    $actualizar = $usuarioModelo->actualizar_usuario($usuario_id, $nombre, $correo, $perfil);

    if ($actualizar) {
        echo json_encode([
            'status' => 'success',
            'message' => 'Usuario actualizado correctamente.'
        ]);
        exit;
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'Error al actualizar el usuario.'
        ]);
        exit;
    }
}

if (isset($_REQUEST['perfil']) && isset($_REQUEST['nombre']) && isset($_REQUEST['correo']) && isset($_REQUEST['clave'])) {
    $perfil = $_REQUEST['perfil'];
    $nombre = $_REQUEST['nombre'];
    $correo = $_REQUEST['correo'];
    $clave = $_REQUEST['clave'];

    $insert = $usuarioModelo->agregar_usuario_crud($perfil,$nombre, $correo, $clave);

    if ($insert) {
        echo json_encode([
            'status' => 'success',
            'message' => 'Registro exitoso.'
        ]);
        exit; // Asegúrate de que no haya más salida
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'Error al registrarte. Inténtalo de nuevo.'
        ]);
        exit;
    }
}



// En caso de que no se cumplan las condiciones anteriores
echo json_encode([
    'status' => 'error',
    'message' => 'Datos incompletos o inválidos.'
]);
exit;
