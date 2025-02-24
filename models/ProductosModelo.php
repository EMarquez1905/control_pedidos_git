<?php

class ProductosModelo
{
    private $conn;

    public function __construct()
    {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    /**
     * Agrega un nuevo producto a la base de datos.
     */
    public function agregar_producto($producto, $codigo_barras, $max, $min, $unidad_medida, $imagen_producto, $id_proveedor, $precio_costo, $precio_venta, $usuario_captura, $estatus)
    {
        date_default_timezone_set('America/Mexico_City');
        $fecha_captura = date('Y-m-d H:i:s');

        $query = "INSERT INTO productos 
                  (producto, codigo_barras, max, min, unidad_medida, imagen_producto, id_proveedor, precio_costo, precio_venta, usuario_captura, estatus, fecha_captura) 
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);

        if ($stmt) {
            $stmt->bind_param('ssiisssddsss', $producto, $codigo_barras, $max, $min, $unidad_medida, $imagen_producto, $id_proveedor, $precio_costo, $precio_venta, $usuario_captura, $estatus, $fecha_captura);
            return $stmt->execute();
        } else {
            error_log("Error en la consulta SQL: " . $this->conn->error);
            return false;
        }
    }

    /**
     * Obtiene todos los productos activos de la base de datos.
     */
    public function obtener_productos()
    {
        $query = "
            SELECT 
                p.id_producto,
                p.producto,
                p.codigo_barras,
                p.max,
                p.min,
                p.unidad_medida,
                p.imagen_producto,
                pr.id_proveedor,  
                pr.nombre AS nombre,  
                p.precio_costo,
                p.precio_venta,
                p.fecha_captura,
                p.estatus
            FROM 
                productos p
            JOIN 
                proveedores pr ON p.id_proveedor = pr.id_proveedor  
            WHERE 
                p.estatus = 'activo'";

        $stmt = $this->conn->prepare($query);
        if (!$stmt) {
            error_log("Error en la consulta SQL: " . $this->conn->error);
            return [];
        }

        $stmt->execute();
        $result = $stmt->get_result();

        if (!$result) {
            error_log("Error obteniendo los datos: " . $stmt->error);
            return [];
        }

        $productos = [];
        while ($row = $result->fetch_assoc()) {
            $productos[] = $row;
        }

        return $productos;
    }

    /**
     * Actualiza un producto existente en la base de datos.
     */
    public function actualizar_producto($id_producto, $producto, $codigo_barras, $max, $min, $unidad_medida, $imagen_producto, $id_proveedor, $precio_costo, $precio_venta, $estatus)
    {
        $query = "UPDATE productos 
                  SET producto = ?, codigo_barras = ?, max = ?, min = ?, unidad_medida = ?, imagen_producto = ?, id_proveedor = ?, precio_costo = ?, precio_venta = ?, estatus = ? 
                  WHERE id_producto = ?";
        $stmt = $this->conn->prepare($query);

        if ($stmt) {
            $stmt->bind_param('ssiisssddssi', $producto, $codigo_barras, $max, $min, $unidad_medida, $imagen_producto, $id_proveedor, $precio_costo, $precio_venta, $estatus, $id_producto);
            return $stmt->execute();
        } else {
            error_log("Error en la consulta SQL: " . $this->conn->error);
            return false;
        }
    }

    /**
     * Elimina (desactiva) un producto de la base de datos.
     */
    public function eliminar_producto($id_producto)
    {
        $query = "UPDATE productos SET estatus = 'inactivo' WHERE id_producto = ?";
        $stmt = $this->conn->prepare($query);

        if ($stmt) {
            $stmt->bind_param('i', $id_producto);
            return $stmt->execute();
        } else {
            error_log("Error en la consulta SQL: " . $this->conn->error);
            return false;
        }
    }

    /**
     * Genera una tabla HTML con los datos de los productos.
     */
    public function generar_tabla($productos)
    {
        $tabla = '';
        if (!empty($productos)) {
            foreach ($productos as $producto) {
                $tabla .= '<tr>';
                $tabla .= '<td>' . htmlspecialchars($producto['id_producto']) . '</td>';
                $tabla .= '<td>' . htmlspecialchars($producto['producto']) . '</td>';
                $tabla .= '<td>' . htmlspecialchars($producto['codigo_barras']) . '</td>';
                $tabla .= '<td>' . htmlspecialchars($producto['max']) . '</td>';
                $tabla .= '<td>' . htmlspecialchars($producto['min']) . '</td>';
                $tabla .= '<td>' . htmlspecialchars($producto['unidad_medida']) . '</td>';
                $tabla .= "<td><img src='../views/assets/images/" . htmlspecialchars($producto['imagen_producto']) . "' width='50'></td>";
                $tabla .= '<td>' . htmlspecialchars($producto['nombre']) . '</td>';
                $tabla .= '<td>' . htmlspecialchars($producto['precio_costo']) . '</td>';
                $tabla .= '<td>' . htmlspecialchars($producto['precio_venta']) . '</td>';
                $tabla .= '<td>' . htmlspecialchars($producto['fecha_captura']) . '</td>';
                $tabla .= '<td>' . htmlspecialchars($producto['estatus']) . '</td>';
                $tabla .= '<td>';
                $tabla .= '<a onclick="actualizarModal(\'' . htmlspecialchars($producto['id_producto']) . '\',
                                                       \'' . htmlspecialchars($producto['producto']) . '\',
                                                       \'' . htmlspecialchars($producto['codigo_barras']) . '\',
                                                       \'' . htmlspecialchars($producto['max']) . '\',
                                                       \'' . htmlspecialchars($producto['min']) . '\',
                                                       \'' . htmlspecialchars($producto['unidad_medida']) . '\',
                                                       \'' . htmlspecialchars($producto['imagen_producto']) . '\',
                                                       \'' . htmlspecialchars($producto['nombre']) . '\',
                                                       \'' . htmlspecialchars($producto['precio_costo']) . '\',
                                                       \'' . htmlspecialchars($producto['precio_venta']) . '\',
                                                       \'' . htmlspecialchars($producto['estatus']) . '\')" class="btn btn-sm btn-primary"><i class="fas fa-sync"></i></a> ';
                $tabla .= '<a data-id="' . htmlspecialchars($producto['id_producto']) . '" class="btn btn-sm btn-danger delete-class"><i class="fas fa-trash"></i></a>';
                $tabla .= '</td>';
                $tabla .= '</tr>';
            }
        } else {
            $tabla .= '<tr><td colspan="12">No hay productos registrados.</td></tr>';
        }
        return $tabla;
    }

    /**
     * Genera un select HTML con los productos.
     */
    public function llenar_select($productos)
    {
        $select = '<select class="form-control" name="producto">';
        $select .= '<option value="">Seleccione un producto</option>';
        if (!empty($productos)) {
            foreach ($productos as $producto) {
                $select .= '<option value="' . htmlspecialchars($producto['id_producto']) . '">' . htmlspecialchars($producto['producto']) . '</option>';
            }
        }
        $select .= '</select>';

        return $select;
    }
}