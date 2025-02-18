<?php
session_start();
if (!empty($_SESSION['activa'])) {
    header("location: ../views/home.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Control de Pedidos | Mercado Insurgente</title>
    <link rel="shortcut icon" href="../views/assets/dist/img/favicon.png" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="../views/assets/plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="../views/assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <link rel="stylesheet" href="../views/assets/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="../views/assets/dist/css/estilosv1.css">
</head>

<body class="hold-transition login-page">
    <div class="login-box">
        <div class="card card-outline card-warning">
            <div class="card-header text-center">
                <img src="../views/assets/dist/img/logo.png" alt="logo" style="max-width: 100%;padding: 10px;">
            </div>
            <div class="card-body">
                <button type="button" id="btn_regresar_login" class="btn btn-light"><i class="fas fa-arrow-left"></i></button>
                <p class="login-box-msg" style="padding-bottom: 0;">¿Olvidaste tu contraseña?</p>
                <p class="login-box-msg">Puedes cambiarla usando tu correo.</p>
                <div class="alert alert-success alert-dismissible fade show" id="correo_verificado" role="alert" style="display: none;">
                    <strong>¡Correo Verificado!</strong> Ahora puede cambiar su contraseña.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="alert alert-success alert-dismissible fade show" id="contrasena_cambiada" role="alert" style="display: none;">
                    <strong>¡Contraseña Cambiada!</strong> Ahora ya puedes iniciar sesion.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="form_verificacion_contrasena">
                    <div class="input-group mb-3">
                        <input type="email" name="correo_recupera" class="form-control" placeholder="Correo">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope text-warning"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <button type="submit" class="btn btn-warning btn-block">Verificar correo</button>
                        </div>
                    </div>
                </form>
                <form id="form_cambiar_contrasena" style="display: none;">
                    <input type="hidden" name="usuario_id" id="usuario_id">
                    <div class="input-group mb-3">
                        <input type="text" class="form-control form-control-correo" id="correo_recupera" placeholder="Correo" readonly>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope text-secondary"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" class="form-control" name="clave_nueva" placeholder="Nueva Contraseña">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock text-warning"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" class="form-control" name="confirma_nueva_clave" placeholder="Confirmar Nueva Contraseña">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock text-warning"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <button type="submit" class="btn btn-warning btn-block">Cambiar contraseña</button>
                        </div>
                    </div>
                </form>
                <button type="button" class="btn btn-warning btn-block" style="display: none;" id="btn_iniciar_sesion">Iniciar Sesión</button>
            </div>
        </div>
    </div>
    <script src="../views/assets/plugins/jquery/jquery.min.js"></script>
    <script src="../views/assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../views/assets/plugins/jquery-validation/jquery.validate.min.js"></script>
    <script src="../views/assets/plugins/jquery-validation/additional-methods.min.js"></script>
    <script src="../views/assets/dist/js/adminlte.min.js"></script>
    <script>
        document.getElementById('btn_regresar_login').addEventListener('click', function() {
            window.location.href = 'login.php';
        });
        $(function() {
            $.validator.setDefaults({
                submitHandler: function(form) {
                    var formData = $(form).serialize();

                    // Primer formulario: Envío de datos
                    $.ajax({
                        type: "POST",
                        url: "../controllers/usuarios/UsuariosController.php", // Cambia la URL al controlador correspondiente
                        data: formData,
                        dataType: 'json',
                        success: function(response) {
                            if (response.status === 'success') {
                                document.getElementById('form_verificacion_contrasena').style.display = 'none';
                                document.getElementById('form_cambiar_contrasena').style.display = 'block';

                                const mensajes = document.querySelectorAll('.login-box-msg');
                                mensajes.forEach(function(mensaje) {
                                    mensaje.style.display = 'none'; // Aplica display: none a cada elemento
                                });
                                document.getElementById('correo_verificado').style.display = 'block';
                                document.getElementById('correo_recupera').value = response.correo;
                                document.getElementById('usuario_id').value = response.id_usuario;
                            } else {
                                $('#form_verificacion_contrasena')[0].reset();
                            }
                        },
                        error: function(xhr, status, error) {
                            alert("Error al enviar el formulario: " + error);
                        }
                    });
                }
            });

            // Validación para el primer formulario
            $('#form_verificacion_contrasena').validate({
                rules: {
                    correo_recupera: {
                        required: true,
                        email: true
                    }
                },
                messages: {
                    correo_recupera: {
                        required: "Por favor, ingrese su correo.",
                        email: "Por favor, ingrese un correo válido."
                    }
                },
                errorElement: 'span',
                errorPlacement: function(error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.input-group').append(error);
                },
                highlight: function(element) {
                    $(element).addClass('is-invalid');
                    if ($(element).attr('name') === 'correo_recupera') {
                        $('.input-group-text .fas').eq(0).removeClass('text-warning').addClass('text-danger');
                    }
                },
                unhighlight: function(element) {
                    $(element).removeClass('is-invalid');
                    if ($(element).attr('name') === 'correo_recupera') {
                        $('.input-group-text .fas').eq(0).removeClass('text-danger').addClass('text-warning');
                    }
                }
            });

            // Validación para el segundo formulario
            $('#form_cambiar_contrasena').validate({
                rules: {
                    clave_nueva: {
                        required: true,
                        minlength: 5
                    },
                    confirma_nueva_clave: {
                        required: true,
                        equalTo: "[name='clave_nueva']" // Verifica que coincida con la contraseña
                    }
                },
                messages: {
                    clave_nueva: {
                        required: "Por favor, ingrese su contraseña.",
                        minlength: "La contraseña debe tener al menos 5 caracteres."
                    },
                    confirma_nueva_clave: {
                        required: "Por favor, repita la contraseña.",
                        equalTo: "Las contraseñas no coinciden."
                    }
                },
                errorElement: 'span',
                errorPlacement: function(error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.input-group').append(error);
                },
                highlight: function(element) {
                    $(element).addClass('is-invalid');
                    if ($(element).attr('name') === 'clave_nueva') {
                        $('.input-group-text .fas').eq(2).removeClass('text-warning').addClass('text-danger');
                    } else if ($(element).attr('name') === 'confirma_nueva_clave') {
                        $('.input-group-text .fas').eq(3).removeClass('text-warning').addClass('text-danger');
                    }
                },
                unhighlight: function(element) {
                    $(element).removeClass('is-invalid');
                    if ($(element).attr('name') === 'clave_nueva') {
                        $('.input-group-text .fas').eq(2).removeClass('text-danger').addClass('text-warning');
                    } else if ($(element).attr('name') === 'confirma_nueva_clave') {
                        $('.input-group-text .fas').eq(3).removeClass('text-danger').addClass('text-warning');
                    }
                },
                submitHandler: function(form) {
                    var formData = $(form).serialize();

                    console.log(formData);

                    // Segundo formulario: Envío de datos
                    $.ajax({
                        type: "POST",
                        url: "../controllers/usuarios/UsuariosController.php", // Cambia la URL al controlador correspondiente
                        data: formData,
                        dataType: 'json',
                        success: function(response) {
                            if (response.status === 'success') {
                                //alert("Contraseña cambiada con éxito.");
                                // Aquí puedes redirigir o realizar alguna acción adicional
                                document.getElementById('form_cambiar_contrasena').style.display = 'none';
                                document.getElementById('btn_iniciar_sesion').style.display = 'block';
                                document.getElementById('correo_verificado').style.display = 'none';
                                document.getElementById('contrasena_cambiada').style.display = 'block';

                                document.getElementById('btn_iniciar_sesion').addEventListener('click', function() {
                                    window.location.href = 'login.php'; // Cambia 'login.html' al nombre de tu archivo de vista de login
                                });
                            } else {
                                //alert("Error al cambiar la contraseña: " + response.message);
                            }
                        },
                        error: function(xhr, status, error) {
                            alert("Error al enviar el formulario de cambio: " + error);
                        }
                    });
                }
            });
        });
    </script>
</body>

</html>