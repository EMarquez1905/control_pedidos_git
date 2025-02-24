<?php
require_once '../../config/database.php';
require_once '../../models/ClientesModelo.php';

$ClientesModelo = new ClientesModelo();

// Habilitar la visualización de errores solo en desarrollo
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json');

if (!isset($_POST['accion'])) {
    http_response_code(400);
    echo json_encode(['status' => 'error', 'message' => 'Acción no especificada.']);
    exit;
}

switch ($_POST['accion']) {
    case 'agregar':
        if (isset($_POST['nombre'], $_POST['rfc'], $_POST['direccion'], $_POST['telefono'],
                  $_POST['nombre_contacto'], $_POST['telefono_contacto'],
                  $_POST['email'], $_POST['razon_fiscal'], $_POST['usuario_captura'], $_POST['estatus'])) {
            $nombre = htmlspecialchars($_POST['nombre']);
            $rfc = htmlspecialchars($_POST['rfc']);
            $direccion = htmlspecialchars($_POST['direccion']);
            $telefono = htmlspecialchars($_POST['telefono']);
            $nombre_contacto = htmlspecialchars($_POST['nombre_contacto']);
            $telefono_contacto = htmlspecialchars($_POST['telefono_contacto']);
            $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) ? $_POST['email'] : null;
            $razon_fiscal = htmlspecialchars($_POST['razon_fiscal']);
            $usuario_captura = (int) $_POST['usuario_captura'];
            $status = $_POST['estatus'];

            if (!$email) {
                http_response_code(400);
                echo json_encode(['status' => 'error', 'message' => 'Correo electrónico no válido.']);
                exit;
            }

            $insert = $ClientesModelo->agregar_cliente($nombre, $rfc, $direccion, $telefono, $nombre_contacto, $telefono_contacto, $email, $razon_fiscal, $usuario_captura, $status);

            if ($insert) {
                http_response_code(201);
                echo json_encode(['status' => 'success', 'message' => 'Cliente agregado exitosamente.']);
            } else {
                http_response_code(500);
                echo json_encode(['status' => 'error', 'message' => 'Error al agregar el cliente.']);
            }
        } else {
            http_response_code(400);
            echo json_encode(['status' => 'error', 'message' => 'Datos incompletos.']);
        }
        break;

    case 'listar':
        $clientes = $ClientesModelo->obtener_clientes();
        http_response_code(200);
        echo json_encode(['status' => 'success', 'data' => $clientes]);
        break;

    case 'actualizar':
        if (isset($_POST['id_cliente'], $_POST['nombre'], $_POST['rfc'], $_POST['direccion'], $_POST['telefono'],
            $_POST['nombre_contacto'], $_POST['telefono_contacto'],
            $_POST['email'], $_POST['razon_fiscal'], $_POST['estatus'])) {

            $id_cliente = (int) $_POST['id_cliente'];
            if ($id_cliente <= 0) {
                http_response_code(400);
                echo json_encode(['status' => 'error', 'message' => 'ID de cliente no válido.']);
                exit;
            }

            $nombre = htmlspecialchars($_POST['nombre']);
            $rfc = htmlspecialchars($_POST['rfc']);
            $direccion = htmlspecialchars($_POST['direccion']);
            $telefono = htmlspecialchars($_POST['telefono']);
            $nombre_contacto = htmlspecialchars($_POST['nombre_contacto']);
            $telefono_contacto = htmlspecialchars($_POST['telefono_contacto']);
            $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) ? $_POST['email'] : null;
            $razon_fiscal = htmlspecialchars($_POST['razon_fiscal']);
            $status = $_POST['estatus'];

            if (!$email) {
                http_response_code(400);
                echo json_encode(['status' => 'error', 'message' => 'Correo electrónico no válido.']);
                exit;
            }

            $update = $ClientesModelo->actualizar_cliente($id_cliente, $nombre, $rfc, $direccion, $telefono, $nombre_contacto, $telefono_contacto, $email, $razon_fiscal, $status);

            if ($update) {
                http_response_code(200);
                echo json_encode(['status' => 'success', 'message' => 'Cliente actualizado exitosamente.']);
            } else {
                http_response_code(500);
                echo json_encode(['status' => 'error', 'message' => 'Error al actualizar el cliente.']);
            }
        } else {
            http_response_code(400);
            echo json_encode(['status' => 'error', 'message' => 'Datos incompletos.']);
        }
        break;

    case 'eliminar':
        if (isset($_POST['id_cliente'])) {
            $id_cliente = (int) $_POST['id_cliente'];
            if ($id_cliente <= 0) {
                http_response_code(400);
                echo json_encode(['status' => 'error', 'message' => 'ID de cliente no válido.']);
                exit;
            }

            $delete = $ClientesModelo->eliminar_cliente($id_cliente);

            if ($delete) {
                http_response_code(200);
                echo json_encode(['status' => 'success', 'message' => 'Cliente eliminado exitosamente.']);
            } else {
                http_response_code(500);
                echo json_encode(['status' => 'error', 'message' => 'Error al eliminar el cliente.']);
            }
        } else {
            http_response_code(400);
            echo json_encode(['status' => 'error', 'message' => 'ID de cliente no proporcionado.']);
        }
        break;

    default:
        http_response_code(400);
        echo json_encode(['status' => 'error', 'message' => 'Acción no válida.']);
}

exit;