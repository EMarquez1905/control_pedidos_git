<?php

class UsuariosModelo
{
    private $conn;

    public function __construct()
    {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function agregar_usuario($nombre, $correo, $clave)
    {
        $nombre = htmlspecialchars(strip_tags($nombre));
        $correo = htmlspecialchars(strip_tags($correo));
        $clave = htmlspecialchars(strip_tags($clave));

        // Cambia md5 por password_hash
        $claveHash = password_hash($clave, PASSWORD_DEFAULT);
        $perfil = 3;
        $imagen = 'default.png';

        $query = "INSERT INTO usuarios(nombre, correo, clave, imagen, id_perfil) VALUES(?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);

        if ($stmt) {
            $stmt->bind_param('ssssi', $nombre, $correo, $claveHash, $imagen, $perfil);
            $result = $stmt->execute();

            return $result; // Devuelve el resultado de la ejecución
        } else {
            return false; // En caso de error en la preparación
        }
    }

    public function agregar_usuario_crud($perfil,$nombre, $correo, $clave)
    {
        $nombre = htmlspecialchars(strip_tags($nombre));
        $correo = htmlspecialchars(strip_tags($correo));
        $clave = htmlspecialchars(strip_tags($clave));

        // Cambia md5 por password_hash
        $claveHash = password_hash($clave, PASSWORD_DEFAULT);
        $imagen = 'default.png';

        $query = "INSERT INTO usuarios(nombre, correo, clave, imagen, id_perfil) VALUES(?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);

        if ($stmt) {
            $stmt->bind_param('ssssi', $nombre, $correo, $claveHash, $imagen, $perfil);
            $result = $stmt->execute();

            return $result; // Devuelve el resultado de la ejecución
        } else {
            return false; // En caso de error en la preparación
        }
    }

    public function verificar_correo($correo)
    {
        $correo = htmlspecialchars(strip_tags($correo));

        $query = "SELECT id_usuario, nombre, correo FROM usuarios WHERE correo = ?"; // Selecciona solo los campos necesarios
        $stmt = $this->conn->prepare($query);

        if ($stmt) {
            $stmt->bind_param('s', $correo);
            $stmt->execute();
            $result = $stmt->get_result();

            return $result->fetch_assoc(); // Devuelve los datos del usuario como un array asociativo
        } else {
            return false;
        }
    }

    public function actualizar_contrasena($usuario, $clave)
    {
        $query = "UPDATE usuarios SET clave = ? WHERE id_usuario = ?";
        $stmt = $this->conn->prepare($query);

        if ($stmt) {
            $stmt->bind_param('si', $clave, $usuario);
            $result = $stmt->execute();

            return $result; // Devuelve los datos del usuario como un array asociativo
        } else {
            return false;
        }
    }

    public function obtener_usuarios()
    {
        // Preparar la consulta SQL
        $query = "SELECT u.*, p.perfil FROM usuarios u INNER JOIN perfiles p ON p.id_perfil = u.id_perfil WHERE u.estatus = 1";

        // Preparar la sentencia
        $stmt = $this->conn->prepare($query);

        if ($stmt) {
            // Ejecutar la consulta
            $stmt->execute();

            // Obtener los resultados como un arreglo asociativo
            $result = $stmt->get_result();
            $usuarios = $result->fetch_all(MYSQLI_ASSOC);

            // Retornar el arreglo de usuarios
            return $usuarios;
        } else {
            // Retornar un arreglo vacío si hay un error
            return [];
        }
    }

    public function eliminar_usuario($usuario)
    {
        $query = "UPDATE usuarios SET estatus = 0 WHERE id_usuario = ?";
        $stmt = $this->conn->prepare($query);

        if ($stmt) {
            $stmt->bind_param('i', $usuario);
            $result = $stmt->execute();

            return $result; // Devuelve los datos del usuario como un array asociativo
        } else {
            return false;
        }
    }


    public function generar_tabla($usuarios)
    {
        $tabla = '';
        if (!empty($usuarios)) {
            // Recorrer los usuarios y generar filas
            foreach ($usuarios as $usuario) {
                $tabla .= '<tr>';
                $tabla .= '<td>' . htmlspecialchars($usuario['id_usuario']) . '</td>';
                $tabla .= '<td>' . htmlspecialchars($usuario['nombre']) . '</td>';
                $tabla .= '<td>' . htmlspecialchars($usuario['correo']) . '</td>';
                $tabla .= '<td>' . htmlspecialchars($usuario['perfil']) . '</td>';
                $tabla .= '<td class="text-center"><img src="../assets/storage/usuarios/' . htmlspecialchars($usuario['imagen']) . '" width="50" height="50"></td>';
                $tabla .= '<td>' . htmlspecialchars($usuario['created_at']) . '</td>';
                $tabla .= '<td>';
                $tabla .= '<a data-toggle="modal" data-target="#actualizar_usuario_' . htmlspecialchars($usuario['id_usuario']) . '" class="btn btn-sm btn-primary"><i class="fas fa-sync"></i></a> ';
                $tabla .= '<a data-id="' . htmlspecialchars($usuario['id_usuario']) . '" class="btn btn-sm btn-danger delete_usuario"><i class="fas fa-trash"></i></a>';
                $tabla .= '</td>';
                $tabla .= '</tr>';

                $tabla .= '
                
                <div class="modal fade modal_usuario_update" id="actualizar_usuario_' . htmlspecialchars($usuario['id_usuario']) . '" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel" style="font-size: 15px; letter-spacing: 1px;"><i class="fas fa-sync"></i>&nbsp;&nbsp;Actualizar Usuario</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form class="form_update_usuario" id="form_update_'.htmlspecialchars($usuario['id_usuario']).'">
                                    <input type="hidden" value="' . htmlspecialchars($usuario['id_usuario']) . '" name="usuario_id">
                                    <label class="form-label" style="width: 100%;font-size: 14px;font-weight: normal;letter-spacing: 1px;">Perfil</label>
                                    <div class="input-group mb-3">
                                        <select style="font-size: 14px;font-weight: normal;letter-spacing: 1px;" class="custom-select" name="perfil_update" id="perfil_update">
                                            <option value="' . htmlspecialchars($usuario['id_perfil']) . '" selected>' . htmlspecialchars($usuario['perfil']) . '</option>
                                            <option value="1">Administrador</option>
                                            <option value="2">Operador</option>
                                            <option value="3">Consultor</option>
                                        </select>
                                        <div class="input-group-append">
                                            <label class="input-group-text" for="inputGroupSelect02"><i class="fas fa-user text-warning"></i></label>
                                        </div>
                                    </div>
                                    <label class="form-label" style="width: 100%;font-size: 14px;font-weight: normal;letter-spacing: 1px;">Nombre:</label>
                                    <div class="input-group mb-3">
                                        <input style="font-size: 14px;font-weight: normal;letter-spacing: 1px;" type="text" class="form-control" name="nombre_update" value="' . htmlspecialchars($usuario['nombre']) . '" placeholder="Nombre completo">
                                        <div class="input-group-append">
                                            <div class="input-group-text">
                                                <span class="fas fa-user text-warning"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <label class="form-label" style="width: 100%;font-size: 14px;font-weight: normal;letter-spacing: 1px;">Correo:</label>
                                    <div class="input-group mb-3">
                                        <input style="font-size: 14px;font-weight: normal;letter-spacing: 1px;" type="email" class="form-control" name="correo_update" value="' . htmlspecialchars($usuario['correo']) . '" placeholder="Correo">
                                        <div class="input-group-append">
                                            <div class="input-group-text">
                                                <span class="fas fa-envelope text-warning"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-12">
                                            <button type="button" onclick="actualizar('.htmlspecialchars($usuario['id_usuario']).');" class="btn btn-warning btn-block">Actualizar</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                ';
            }
        } else {
            // Si no hay usuarios, mostrar un mensaje
        }
        // Retornar la tabla generada
        return $tabla;
    }

    public function actualizar_usuario($usuario_id, $nombre, $correo, $perfil)
    {
        $query = "UPDATE usuarios SET nombre = ?, correo = ?, id_perfil = ? WHERE id_usuario = ?";
        $stmt = $this->conn->prepare($query);

        if ($stmt) {
            $stmt->bind_param('ssii', $nombre, $correo, $perfil, $usuario_id);
            return $stmt->execute(); // Devuelve true si la consulta fue exitosa
        } else {
            return false; // Devuelve false si hubo un error
        }
    }
}
