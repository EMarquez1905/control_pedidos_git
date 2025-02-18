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
                <img src="../views/assets/dist/img/logo.png" alt="logo" style="max-width: 100%;padding: 10px;"><br />
            </div>
            <div class="card-body">
                <p class="login-box-msg">Estás a sólo un paso de tu nueva contraseña, recupera tu contraseña ahora.</p>
                <form action="login.html" method="post">
                    <div class="input-group mb-3">
                        <input type="password" class="form-control" placeholder="Contraseña">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock text-warning"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" class="form-control" placeholder="Confirmar Contraseña">
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

                <p class="mt-3 mb-1">
                    <a href="login.php">Inicia Sesión</a>
                </p>
            </div>
        </div>
    </div>
    <script src="../views/assets/plugins/jquery/jquery.min.js"></script>
    <script src="../views/assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../views/assets/dist/js/adminlte.min.js"></script>
</body>

</html>