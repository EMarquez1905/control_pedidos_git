<?php
session_start();
if (empty($_SESSION['activa'])) {
    header("Location: ../public/login.php");
}
?>
<!DOCTYPE html>
<html lang="es">

<?php include("includes/header.php"); ?>

<body class="hold-transition sidebar-mini sidebar-collapse">
    <div class="wrapper">
        <?php include("includes/navbar.php") ?>
        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0"><i class="fas fa-chart-bar"></i>&nbsp;&nbsp;Panel de Administración</h1>
                            <p>Bienvenido al sistema: <strong><?php echo $_SESSION['nombre']; ?></strong></p>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">Inicio</a></li>
                                <li class="breadcrumb-item active">Dashboard</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content">
                <div class="container-fluid">
                    
                </div>
            </div>
        </div>
        <?php include("includes/footer.php") ?>
    </div>
    <?php include("includes/scripts.php"); ?>
</body>

</html>