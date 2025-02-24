<?php

class ProveedoresModelo
{
    private $conn;

    public function __construct()
    {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function agregar_proveedor($nombre, $rfc, $direccion, $telefono, $nombre_contacto, $telefono_contacto, $nombre_comercial, $email, $razon_fiscal, $usuario_captura, $estatus)
    {
        // Establecer la zona horaria de México
        date_default_timezone_set('America/Mexico_City');

        // Obtener la fecha y hora actual de México
        $fecha_captura = date('Y-m-d H:i:s');

        $query = "INSERT INTO proveedores 
        (nombre, rfc, direccion, telefono, nombre_contacto, telefono_contacto, nombre_comercial, email, razon_fiscal, usuario_captura, estatus, fecha_captura) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"; // 12 signos de interrogación
        $stmt = $this->conn->prepare($query);

        if ($stmt) {
            $stmt->bind_param('ssssssssssss', $nombre, $rfc, $direccion, $telefono, $nombre_contacto, $telefono_contacto, $nombre_comercial, $email, $razon_fiscal, $usuario_captura, $estatus, $fecha_captura); // 12 parámetros
            return $stmt->execute();
        } else {
            return false;
        }
    }
    public function obtener_proveedores()
    {
        $query = "SELECT * FROM proveedores WHERE estatus = 'activo'";
        $stmt = $this->conn->prepare($query);

        if ($stmt) {
            $stmt->execute();
            $result = $stmt->get_result();
            return $result->fetch_all(MYSQLI_ASSOC);
        } else {
            return [];
        }
    }

    public function actualizar_proveedor($id_proveedor, $nombre, $rfc, $direccion, $telefono, $nombre_contacto, $telefono_contacto, $nombre_comercial, $email, $razon_fiscal, $estatus)
    {
        $query = "UPDATE proveedores SET nombre = ?, rfc = ?, direccion = ?, telefono = ?, nombre_contacto = ?, telefono_contacto = ?, nombre_comercial = ?, email = ?, razon_fiscal = ?, estatus = ? WHERE id_proveedor = ?";
        $stmt = $this->conn->prepare($query);

        if ($stmt) {
            $stmt->bind_param('ssssssssssi', $nombre, $rfc, $direccion, $telefono, $nombre_contacto, $telefono_contacto, $nombre_comercial, $email, $razon_fiscal, $estatus, $id_proveedor);
            return $stmt->execute();
        } else {
            return false;
        }
    }

    public function eliminar_proveedor($id_proveedor)
    {
        $query = "UPDATE proveedores SET estatus = 'inactivo' WHERE id_proveedor = ?";
        $stmt = $this->conn->prepare($query);

        if ($stmt) {
            $stmt->bind_param('i', $id_proveedor);
            return $stmt->execute();
        } else {
            return false;
        }
    }

    public function generar_tabla($proveedores)
    {
        $tabla = '';
        if (!empty($proveedores)) {
            foreach ($proveedores as $proveedor) {
                $tabla .= '<tr>';
                $tabla .= '<td>' . htmlspecialchars($proveedor['id_proveedor']) . '</td>';
                $tabla .= '<td>' . htmlspecialchars($proveedor['nombre']) . '</td>';
                $tabla .= '<td>' . htmlspecialchars($proveedor['rfc']) . '</td>';
                $tabla .= '<td>' . htmlspecialchars($proveedor['direccion']) . '</td>';
                $tabla .= '<td>' . htmlspecialchars($proveedor['telefono']) . '</td>';
                $tabla .= '<td>' . htmlspecialchars($proveedor['nombre_contacto']) . '</td>';
                $tabla .= '<td>' . htmlspecialchars($proveedor['telefono_contacto']) . '</td>';
                $tabla .= '<td>' . htmlspecialchars($proveedor['nombre_comercial']) . '</td>';
                $tabla .= '<td>' . htmlspecialchars($proveedor['email']) . '</td>';
                $tabla .= '<td>' . htmlspecialchars($proveedor['razon_fiscal']) . '</td>';
                $tabla .= '<td>' . htmlspecialchars($proveedor['fecha_captura']) . '</td>';
                $tabla .= '<td>' . htmlspecialchars($proveedor['estatus']) . '</td>';
                $tabla .= '<td>';
                // $tabla .= '<a data-toggle="modal" data-target="#proveedor_add" class="btn btn-sm btn-primary"><i class="fas fa-sync"></i></a> ';
                $tabla .= '<a onclick="actualizarModal(\'' . $proveedor['id_proveedor'] . '\',
                                                   \'' . $proveedor['nombre'] . '\',
                                                   \'' . $proveedor['rfc'] . '\',
                                                   \'' . $proveedor['direccion'] . '\',
                                                   \'' . $proveedor['telefono'] . '\',
                                                   \'' . $proveedor['nombre_contacto'] . '\',
                                                   \'' . $proveedor['telefono_contacto'] . '\',
                                                   \'' . $proveedor['nombre_comercial'] . '\',
                                                   \'' . $proveedor['email'] . '\',
                                                   \'' . $proveedor['razon_fiscal'] . '\',
                                                   \'' . $proveedor['estatus'] . '\')" class="btn btn-sm btn-primary"><i class="fas fa-sync"></i></a> ';
                $tabla .= '<a data-id="' . htmlspecialchars($proveedor['id_proveedor']) . '" class="btn btn-sm btn-danger delete-class"><i class="fas fa-trash"></i></a>';
                $tabla .= '</td>';
                $tabla .= '</tr>';
            }
        } else {
            $tabla .= '<tr><td colspan="12">No hay proveedores registrados.</td></tr>';
        }
        return $tabla;
    }

    public function llenar_select()
    {
        $query = "SELECT * FROM proveedores WHERE estatus = 'activo'";
        $stmt = $this->conn->prepare($query);

        if ($stmt) {
            $stmt->execute();
            $result = $stmt->get_result();
            $result->fetch_all(MYSQLI_ASSOC);
            
            $select = '<select class="form-control" id="id_proveedor" name="id_proveedor">';
            if (!empty($result)) {
                foreach ($result as $proveedor) {
                    $select .= '<option value="' . htmlspecialchars($proveedor['id_proveedor']) . '">' . htmlspecialchars($proveedor['nombre']) . '</option>';                
                }
            } 
            $select .= '</select>';

            return $select;
        } else {
            return [];
        }

        
    }
}

                                                        