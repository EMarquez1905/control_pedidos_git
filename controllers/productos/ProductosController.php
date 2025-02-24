<?php
require_once '../../config/database.php';
require_once '../../models/ProductosModelo.php';

$productosModelo = new ProductosModelo();

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
        if (isset($_POST['producto'], $_POST['codigo_barras'], $_POST['max'], $_POST['min'], $_POST['unidad_medida'],
                  $_FILES['imagen_producto'], $_POST['id_proveedor'], $_POST['precio_costo'], $_POST['precio_venta'],
                  $_POST['usuario_captura'], $_POST['estatus'])) {

            // Validar y sanitizar datos
            $producto = htmlspecialchars($_POST['producto']);
            $codigo_barras = htmlspecialchars($_POST['codigo_barras']);
            $max = (int) $_POST['max'];
            $min = (int) $_POST['min'];
            $unidad_medida = htmlspecialchars($_POST['unidad_medida']);
            $id_proveedor = (int) $_POST['id_proveedor'];
            $precio_costo = (float) $_POST['precio_costo'];
            $precio_venta = (float) $_POST['precio_venta'];
            $usuario_captura = (int) $_POST['usuario_captura'];
            $estatus = htmlspecialchars($_POST['estatus']);

            // Manejar la subida de la imagen
            if ($_FILES['imagen_producto']['error'] === UPLOAD_ERR_OK) {
                $imagen_temporal = $_FILES['imagen_producto']['tmp_name'];
                $nombre_imagen = basename($_FILES['imagen_producto']['name']);
                $ruta_imagen = '../../views/assets/images/' . $nombre_imagen; // Ajusta la ruta según tu proyecto

                // Mover el archivo a la carpeta de imágenes
                if (move_uploaded_file($imagen_temporal, $ruta_imagen)) {
                    $imagen_producto = $nombre_imagen; // Guardar el nombre de la imagen en la base de datos
                } else {
                    http_response_code(500);
                    echo json_encode(['status' => 'error', 'message' => 'Error al subir la imagen.']);
                    exit;
                }
            } else {
                $imagen_producto = ''; // O un valor por defecto si no se sube una imagen
            }

            // Insertar el producto en la base de datos
            $insert = $productosModelo->agregar_producto($producto, $codigo_barras, $max, $min, $unidad_medida, $imagen_producto, $id_proveedor, $precio_costo, $precio_venta, $usuario_captura, $estatus);

            if ($insert) {
                http_response_code(201);
                echo json_encode(['status' => 'success', 'message' => 'Producto agregado exitosamente.']);
            } else {
                http_response_code(500);
                echo json_encode(['status' => 'error', 'message' => 'Error al agregar el producto.']);
            }
        } else {
            http_response_code(400);
            echo json_encode(['status' => 'error', 'message' => 'Datos incompletos.']);
        }
        break;

    case 'listar':
        $productos = $productosModelo->obtener_productos();
        http_response_code(200);
        echo json_encode(['status' => 'success', 'data' => $productos]);
        break;

    case 'actualizar':
        if (isset($_POST['id_producto'], $_POST['producto'], $_POST['codigo_barras'], $_POST['max'], $_POST['min'],
                  $_POST['unidad_medida'], $_FILES['imagen_producto'], $_POST['id_proveedor'], $_POST['precio_costo'],
                  $_POST['precio_venta'], $_POST['estatus'])) {

            // Validar y sanitizar datos
            $id_producto = (int) $_POST['id_producto'];
            $producto = htmlspecialchars($_POST['producto']);
            $codigo_barras = htmlspecialchars($_POST['codigo_barras']);
            $max = (int) $_POST['max'];
            $min = (int) $_POST['min'];
            $unidad_medida = htmlspecialchars($_POST['unidad_medida']);
            $id_proveedor = (int) $_POST['id_proveedor'];
            $precio_costo = (float) $_POST['precio_costo'];
            $precio_venta = (float) $_POST['precio_venta'];
            $estatus = htmlspecialchars($_POST['estatus']);

            // Manejar la subida de la imagen (si se proporciona una nueva imagen)
            if ($_FILES['imagen_producto']['error'] === UPLOAD_ERR_OK) {
                $imagen_temporal = $_FILES['imagen_producto']['tmp_name'];
                $nombre_imagen = basename($_FILES['imagen_producto']['name']);
                $ruta_imagen = '../../images/' . $nombre_imagen; // Ajusta la ruta según tu proyecto

                // Mover el archivo a la carpeta de imágenes
                if (move_uploaded_file($imagen_temporal, $ruta_imagen)) {
                    $imagen_producto = $nombre_imagen; // Guardar el nombre de la imagen en la base de datos
                } else {
                    http_response_code(500);
                    echo json_encode(['status' => 'error', 'message' => 'Error al subir la imagen.']);
                    exit;
                }
            } else {
                // Si no se sube una nueva imagen, mantener la imagen actual
                $imagen_producto = $_POST['imagen_actual']; // Asegúrate de pasar 'imagen_actual' desde el formulario
            }

            // Actualizar el producto en la base de datos
            $update = $productosModelo->actualizar_producto($id_producto, $producto, $codigo_barras, $max, $min, $unidad_medida, $imagen_producto, $id_proveedor, $precio_costo, $precio_venta, $estatus);

            if ($update) {
                http_response_code(200);
                echo json_encode(['status' => 'success', 'message' => 'Producto actualizado exitosamente.']);
            } else {
                http_response_code(500);
                echo json_encode(['status' => 'error', 'message' => 'Error al actualizar el producto.']);
            }
        } else {
            http_response_code(400);
            echo json_encode(['status' => 'error', 'message' => 'Datos incompletos.']);
        }
        break;

    case 'eliminar':
        if (isset($_POST['id_producto'])) {
            $id_producto = (int) $_POST['id_producto'];
            $delete = $productosModelo->eliminar_producto($id_producto);

            if ($delete) {
                http_response_code(200);
                echo json_encode(['status' => 'success', 'message' => 'Producto eliminado exitosamente.']);
            } else {
                http_response_code(500);
                echo json_encode(['status' => 'error', 'message' => 'Error al eliminar el producto.']);
            }
        } else {
            http_response_code(400);
            echo json_encode(['status' => 'error', 'message' => 'ID de producto no proporcionado.']);
        }
        break;

    default:
        http_response_code(400);
        echo json_encode(['status' => 'error', 'message' => 'Acción no válida.']);
}

exit;