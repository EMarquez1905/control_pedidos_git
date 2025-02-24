<?php
session_start();
if (empty($_SESSION['activa'])) {
    header("Location: ../../public/login.php");
    exit; // Asegura que el script se detenga si la sesión no está activa
}
?>
<!DOCTYPE html>
<html lang="es">

<?php include("../includes/header.php"); ?>

<body class="hold-transition sidebar-mini sidebar-collapse">
    <div class="wrapper">
        <?php include("../includes/navbar.php") ?>
        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0"><i class="fas fa-boxes"></i>&nbsp;&nbsp;Listado de Productos</h1>
                            <p>En esta sección se administrará todos los productos del sistema. <?php echo htmlspecialchars($_SESSION['activa']); ?></p>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="<?php echo $root; ?>views/home.php">Inicio</a></li>
                                <li class="breadcrumb-item active">Catálogos</li>
                                <li class="breadcrumb-item active">Productos</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content">
                <div class="container-fluid">
                    <div class="card">
                        <div class="card-header">
                            <button type="button" data-toggle="modal" data-target="#producto_add" class="btn btn-warning float-right">Agregar Producto&nbsp;&nbsp;<i class="fas fa-plus"></i></button>
                        </div>
                        <div class="card-body">
                            <!-- Modal de agregar -->
                            <div class="modal fade modal_producto_add" id="producto_add" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel"><i class="fas fa-box"></i>&nbsp;&nbsp;Agregar Producto</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="alert alert-success alert-dismissible fade show" id="registro_exitoso" role="alert" style="display: none;">
                                                ¡Felicidades! Has registrado con éxito el producto.
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <form id="formProductoAdd" enctype="multipart/form-data">
                                                <input type="hidden" class="form-control" id="usuario_captura" name='usuario_captura' value="<?php echo htmlspecialchars($_SESSION['usuario_id']); ?>">
                                                <input type="hidden" class="form-control" id="accion" name='accion' value='agregar'>

                                                <label class="form-label" style="width: 100%;">Nombre del Producto:</label>
                                                <div class="input-group mb-3">
                                                    <input type="text" class="form-control" id="producto" name='producto' placeholder="Nombre del producto">
                                                    <div class="input-group-append">
                                                        <div class="input-group-text">
                                                            <span class="fas fa-cube text-warning"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <label class="form-label" style="width: 100%;">Código de Barras:</label>
                                                <div class="input-group mb-3">
                                                    <input type="text" class="form-control" id="codigo_barras" name="codigo_barras" placeholder="Código de barras">
                                                    <div class="input-group-append">
                                                        <div class="input-group-text">
                                                            <span class="fas fa-barcode text-warning"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <label class="form-label" style="width: 100%;">Máximo:</label>
                                                <div class="input-group mb-3">
                                                    <input type="number" class="form-control" id="max" name="max" placeholder="Máximo">
                                                    <div class="input-group-append">
                                                        <div class="input-group-text">
                                                            <span class="fas fa-arrow-up text-warning"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <label class="form-label" style="width: 100%;">Mínimo:</label>
                                                <div class="input-group mb-3">
                                                    <input type="number" class="form-control" id="min" name="min" placeholder="Mínimo">
                                                    <div class="input-group-append">
                                                        <div class="input-group-text">
                                                            <span class="fas fa-arrow-down text-warning"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <label class="form-label" style="width: 100%;">Unidad de Medida:</label>
                                                <div class="input-group mb-3">
                                                    <input type="text" class="form-control" id="unidad_medida" name="unidad_medida" placeholder="Unidad de medida">
                                                    <div class="input-group-append">
                                                        <div class="input-group-text">
                                                            <span class="fas fa-balance-scale text-warning"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <label class="form-label" style="width: 100%;">Imagen del Producto:</label>
                                                <div class="input-group mb-3">
                                                    <input type="file"
                                                        class="form-control"
                                                        id="imagen_producto"
                                                        name="imagen_producto"
                                                        accept="image/*">
                                                    <div class="input-group-append">
                                                        <div class="input-group-text">
                                                            <span class="fas fa-image text-warning"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <label class="form-label" style="width: 100%;">Proveedor:</label>
                                                <div class="input-group mb-3">
                                                    <select class="form-control" id="id_proveedor" name="id_proveedor">
                                                        <option value="">Seleccione un proveedor</option>
                                                        <?php
                                                        require_once("../../config/database.php");
                                                        require_once("../../models/ProveedoresModelo.php");
                                                        $proveedorModelo = new ProveedoresModelo();
                                                        $proveedores = $proveedorModelo->obtener_proveedores();
                                                        foreach ($proveedores as $proveedor) {
                                                            echo '<option value="' . htmlspecialchars($proveedor['id_proveedor']) . '">' . htmlspecialchars($proveedor['nombre']) . '</option>';
                                                        }
                                                        ?>
                                                    </select>
                                                    <div class="input-group-append">
                                                        <div class="input-group-text">
                                                            <span class="fas fa-truck text-warning"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <label class="form-label" style="width: 100%;">Precio de Costo:</label>
                                                <div class="input-group mb-3">
                                                    <input type="text" class="form-control" id="precio_costo" name="precio_costoUp" placeholder="Precio de costo">
                                                    <div class="input-group-append">
                                                        <div class="input-group-text">
                                                            <span class="fas fa-dollar-sign text-warning"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <label class="form-label" style="width: 100%;">Precio de Venta:</label>
                                                <div class="input-group mb-3">
                                                    <input type="text" class="form-control" id="precio_venta" name="precio_venta" placeholder="Precio de venta">
                                                    <div class="input-group-append">
                                                        <div class="input-group-text">
                                                            <span class="fas fa-tag text-warning"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <label class="form-label" style="width: 100%;">Estatus:</label>
                                                <div class="input-group mb-3">
                                                    <select class="form-control" id="estatus" name="estatus">
                                                        <option value="activo">Activo</option>
                                                        <option value="inactivo">Inactivo</option>
                                                    </select>
                                                    <div class="input-group-append">
                                                        <div class="input-group-text">
                                                            <span class="fas fa-toggle-on text-success"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col-12">
                                                        <button type="submit" class="btn btn-warning btn-block">Registrar Producto</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Modal de actualizar producto -->
                            <div class="modal fade modal_producto_add" id="producto_update" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel"><i class="fas fa-sync"></i>&nbsp;&nbsp;Actualizar producto</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="alert alert-success alert-dismissible fade show" id="update_exitoso" role="alert" style="display: none;">
                                                ¡Felicidades! Has actualizado con éxito el producto.
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <form id="form_update" enctype="multipart/form-data">
                                                <input type="hidden" class="form-control" id="id_productoUp" name='id_producto' value=''>
                                                <input type="hidden" class="form-control" name='accion' value='actualizar'>

                                                <label class="form-label" style="width: 100%;">Nombre:</label>
                                                <div class="input-group mb-3">
                                                    <input type="text" class="form-control" id='productoUp' name='nombre' placeholder="Nombre del producto">
                                                    <div class="input-group-append">
                                                        <div class="input-group-text">
                                                            <span class="fas fa-box text-warning"></span>
                                                        </div>
                                                    </div>
                                                </div>

                                                <label class="form-label" style="width: 100%;">Código de Barras:</label>
                                                <div class="input-group mb-3">
                                                    <input type="text" class="form-control" id="codigo_barrasUp" name="codigo_barras" placeholder="Código de barras">
                                                    <div class="input-group-append">
                                                        <div class="input-group-text">
                                                            <span class="fas fa-barcode text-warning"></span>
                                                        </div>
                                                    </div>
                                                </div>

                                                <label class="form-label" style="width: 100%;">Máximo:</label>
                                                <div class="input-group mb-3">
                                                    <input type="number" class="form-control" id="maxUp" name="max" placeholder="Máximo">
                                                    <div class="input-group-append">
                                                        <div class="input-group-text">
                                                            <span class="fas fa-arrow-up text-warning"></span>
                                                        </div>
                                                    </div>
                                                </div>

                                                <label class="form-label" style="width: 100%;">Mínimo:</label>
                                                <div class="input-group mb-3">
                                                    <input type="number" class="form-control" id="minUp" name="min" placeholder="Mínimo">
                                                    <div class="input-group-append">
                                                        <div class="input-group-text">
                                                            <span class="fas fa-arrow-down text-warning"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <label class="form-label" style="width: 100%;">Unidad de Medida:</label>
                                                <div class="input-group mb-3">
                                                    <input type="text" class="form-control" id="unidad_medidaUp" name="unidad_medida" placeholder="Unidad de medida">
                                                    <div class="input-group-append">
                                                        <div class="input-group-text">
                                                            <span class="fas fa-balance-scale text-warning"></span>
                                                        </div>
                                                    </div>
                                                </div>

                                                <label class="form-label" style="width: 100%;">Imagen del Producto:</label>
                                                <div class="input-group mb-3">
                                                    <input type="file" class="form-control" id="imagen_productoUp" name="imagen_producto" accept="image/*" onchange="mostrarImagen(event)">
                                                    <div class="input-group-append">
                                                        <div class="input-group-text">
                                                            <span class="fas fa-image text-warning"></span>
                                                        </div>
                                                    </div>
                                                </div>

                                                <label class="form-label" style="width: 100%;">Proveedor:</label>
                                                <div class="input-group mb-3">
                                                    <select class="form-control" id="id_proveedorUp" name="id_proveedor">
                                                        <option value="">Seleccione un proveedor</option>
                                                        <?php
                                                        require_once("../../config/database.php");
                                                        require_once("../../models/ProveedoresModelo.php");
                                                        $proveedorModelo = new ProveedoresModelo();
                                                        $proveedores = $proveedorModelo->obtener_proveedores();
                                                        foreach ($proveedores as $proveedor) {
                                                            echo '<option value="' . htmlspecialchars($proveedor['id_proveedor']) . '">' . htmlspecialchars($proveedor['nombre']) . '</option>';
                                                        }
                                                        ?>
                                                    </select>
                                                    <div class="input-group-append">
                                                        <div class="input-group-text">
                                                            <span class="fas fa-truck text-warning"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <input type="hidden" id="proveedor_id" name="proveedor_id">
                                                <label class="form-label" style="width: 100%;">Precio de Costo:</label>
                                                <div class="input-group mb-3">
                                                    <input type="text" class="form-control" id="precio_costoUp" name="precio_costoUp" placeholder="Precio de costo">
                                                    <div class="input-group-append">
                                                        <div class="input-group-text">
                                                            <span class="fas fa-dollar-sign text-warning"></span>
                                                        </div>
                                                    </div>
                                                </div>

                                                <label class="form-label" style="width: 100%;">Precio de Venta:</label>
                                                <div class="input-group mb-3">
                                                    <input type="text" class="form-control" id="precio_ventaUp" name="precio_ventaUp" placeholder="Precio de venta">
                                                    <div class="input-group-append">
                                                        <div class="input-group-text">
                                                            <span class="fas fa-tag text-warning"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <label class="form-label" style="width: 100%;">Estatus:</label>
                                                <div class="input-group mb-3">
                                                    <select class="form-control" id="estatusUp" name="estatus">
                                                        <option value="activo">Activo</option>
                                                        <option value="inactivo">Inactivo</option>
                                                    </select>
                                                    <div class="input-group-append">
                                                        <div class="input-group-text">
                                                            <span class="fas fa-toggle-on text-success"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col-12">
                                                        <button type="button" onclick="actualizar()" class="btn btn-warning btn-block">Actualizar</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table id="proveedores" class="table table-bordered table-striped">
                                    <thead class="table-thead-section">
                                        <th>Id</th>
                                        <th>Producto</th>
                                        <th>Código de Barras</th>
                                        <th>Max</th>
                                        <th>Min</th>
                                        <th>Unidad de medida</th>
                                        <th>Imagen Producto</th>
                                        <th>Proveedor</th>
                                        <th>Precio de Costo</th>
                                        <th>Precio de Venta</th>
                                        <th>Fecha de Registro</th>
                                        <th>Estatus</th>
                                        <th>Acciones</th>
                                    </thead>
                                    <tbody>
                                        <?php
                                        require_once("../../config/database.php");
                                        require_once("../../models/ProductosModelo.php");

                                        $productoModelo = new ProductosModelo();

                                        $productos = $productoModelo->obtener_productos();
                                        $tabla = $productoModelo->generar_tabla($productos);
                                        echo $tabla;
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php include("../includes/footer.php") ?>
    </div>
    <?php include("../includes/scripts.php"); ?>
    <script>
        $(document).ready(function() {
            $('.delete-class').on('click', function(e) {
                e.preventDefault();
                const productoId = $(this).data('id');

                Swal.fire({
                    title: '¿Realmente quieres eliminar este producto?',
                    text: "No podrás revertir esto.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d4ac4c',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Sí, eliminarlo',
                    cancelButtonText: 'No, cancelar',
                    customClass: {
                        confirmButton: 'swal2-confirm swal2-styled',
                        cancelButton: 'swal2-cancel swal2-styled'
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '../../controllers/productos/ProductosController.php',
                            type: 'POST',
                            data: {
                                accion: 'eliminar',
                                id_producto: productoId
                            },
                            success: function(res) {
                                if (res.status === 'success') {
                                    Swal.fire(
                                        'Eliminado',
                                        res.message,
                                        'success'
                                    ).then(() => {
                                        location.reload();
                                    });
                                } else {
                                    Swal.fire(
                                        'Error',
                                        res.message,
                                        'error'
                                    );
                                }
                            },
                            error: function(xhr, status, error) {
                                Swal.fire(
                                    'Error',
                                    'Hubo un problema al intentar eliminar el producto.',
                                    'error'
                                );
                                console.error('Error al eliminar el producto:', error);
                            }
                        });
                    }
                });
            });
        });

        
        // Abre el modal y pone los datos
        function actualizarModal(id_producto, producto, codigo_barras, max, min, unidad_medida, imagen_producto, id_proveedor, precio_costo, precio_venta, estatus) {
            $('#producto_update').modal('show');
            $("#id_productoUp").val(id_producto);
            $("#productoUp").val(producto);
            $("#codigo_barrasUp").val(codigo_barras);
            $("#maxUp").val(max);
            $("#minUp").val(min);
            $("#unidad_medidaUp").val(unidad_medida);
            $("#imagen_productoUp").val(imagen_producto);
            $("#id_proveedorUp").val(id_proveedor);
            $("#precio_costoUp").val(precio_costo);
            $("#precio_ventaUp").val(precio_venta);
            $("#estatusUp").val(estatus);
        }

        function actualizar() {
            var form = document.getElementById('form_update');
            var formData = new FormData(form);

            $.ajax({
                type: "POST",
                url: "../../controllers/productos/ProductosController.php",
                data: formData,
                dataType: 'json',
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.status === 'success') {
                        Swal.fire(
                            'Actualizado',
                            response.message,
                            'success'
                        ).then(() => {
                            location.reload();
                        });
                    } else {
                        Swal.fire(
                            'Error',
                            response.message,
                            'error'
                        );
                    }
                },
                error: function(xhr, status, error) {
                    Swal.fire(
                        'Error',
                        'Hubo un problema al intentar actualizar la información.',
                        'error'
                    );
                    console.error("Error al enviar el formulario:", error);
                }
            });
        }
        // Agregar
        $(function() {
            $.validator.setDefaults({
                submitHandler: function(form) {
                    var fileData = $('input[type=file]').prop('files')[0];
                    var formData = new FormData();

                    formData.append('usuario_captura', $("#usuario_captura").val());
                    formData.append('accion', $("#accion").val());
                    formData.append('producto', $("#producto").val());
                    formData.append('codigo_barras', $("#codigo_barras").val());
                    formData.append('max', $("#max").val());
                    formData.append('min', $("#min").val());
                    formData.append('unidad_medida', $("#unidad_medida").val());
                    formData.append('imagen_producto', fileData);
                    formData.append('id_proveedor', $("#id_proveedor").val());
                    formData.append('precio_costo', $("#precio_costo").val());
                    formData.append('precio_venta', $("#precio_venta").val());
                    formData.append('estatus', $("#estatus").val());

                    console.log(formData);

                    $.ajax({
                        type: "POST",
                        url: "../../controllers/productos/ProductosController.php",
                        data: formData,
                        dataType: 'json',
                        cache: false,
                        processData: false,
                        success: function(response) {
                            if (response.status === 'success') {
                                $('#formProductoAdd')[0].reset();
                                Swal.fire(
                                    'Producto Agregado',
                                    response.message,
                                    'success'
                                ).then(() => {
                                    // location.reload();
                                });
                            } else {
                                $('#formProductoAdd')[0].reset();
                                alert(response.message);
                            }
                        },
                        error: function(xhr, status, error) {
                            alert("Error al enviar el formulario: " + error);
                        }
                    });
                }
            });

            $('#formProductoAdd').validate({
                rules: {
                    producto: {
                        required: true,
                        minlength: 2
                    },
                    codigo_barras: {
                        required: true
                    },
                    max: {
                        required: true,
                        number: true
                    },
                    min: {
                        required: true,
                        number: true
                    },
                    unidad_medida: {
                        required: true
                    },
                    id_proveedor: {
                        required: true
                    },
                    precio_costo: {
                        required: true,
                        number: true
                    },
                    precio_venta: {
                        required: true,
                        number: true
                    }
                },
                messages: {
                    producto: {
                        required: "Por favor, ingrese un nombre.",
                    },
                    codigo_barras: {
                        required: "Por favor, ingrese el código de barras.",
                    },
                    max: {
                        required: "Ingrese el stock máximo."
                    },
                    min: {
                        required: "Ingrese el stock mínimo."
                    },
                    unidad_medida: {
                        required: "Ingrese la unidad de medida."
                    },
                    id_proveedor: {
                        required: "Seleccione un proveedor.",
                    },
                    precio_costo: {
                        required: "Ingrese el precio de costo."
                    },
                    precio_venta: {
                        required: "Ingrese el precio de venta."
                    }
                },
                errorElement: 'span',
                errorPlacement: function(error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.input-group').append(error);
                },
                highlight: function(element, errorClass, validClass) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                }
            });
        });
    </script>
</body>

</html>