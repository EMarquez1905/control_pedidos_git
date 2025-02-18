<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="<?php echo $root; ?>views/home.php" class="nav-link">Dashboard</a>
        </li>
    </ul>
    <ul class="navbar-nav ml-auto">
        <li class="nav-item">
            <a class="nav-link" data-widget="navbar-search" href="#" role="button">
                <i class="fas fa-search"></i>
            </a>
            <div class="navbar-search-block">
                <form class="form-inline">
                    <div class="input-group input-group-sm">
                        <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
                        <div class="input-group-append">
                            <button class="btn btn-navbar" type="submit">
                                <i class="fas fa-search"></i>
                            </button>
                            <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link logout-link" href="<?php echo $root; ?>public/logout.php" role="button">
                <i class="fas fa-sign-out-alt"></i>
            </a>
        </li>
    </ul>
</nav>
<aside class="main-sidebar sidebar-light-primary elevation-4">
    <a href="index3.html" class="brand-link">
        <img src="<?php echo $root; ?>views/assets/dist/img/favicon.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
            style="opacity: .8; background-color: white; padding: 1px;">
        <span class="brand-text font-weight-light">Control de Pedidos</span>
    </a>
    <div class="sidebar">
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="<?php echo $root; ?>views/assets/storage/usuarios/<?php echo $_SESSION['imagen'] ?>" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block"><?php echo $_SESSION['nombre']; ?></a>
            </div>
        </div>
        <div class="form-inline">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-sidebar">
                        <i class="fas fa-search fa-fw"></i>
                    </button>
                </div>
            </div>
        </div>
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="<?php echo $root; ?>views/home.php" class="nav-link">
                        <i class="nav-icon fas fa-chart-bar"></i>
                        <p> Dashboard</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link ">
                        <i class="nav-icon fas fa-book"></i>
                        <p>
                            Catálogos
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?php echo $root; ?>views/clientes/" class="nav-link ">
                                <i class="far fa-circle nav-icon"></i>
                                <p> Clientes</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo $root; ?>views/productos/" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p> Productos</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo $root; ?>views/proveedores/" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p> Proveedores</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo $root; ?>views/usuarios/" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p> Usuarios</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link ">
                        <i class="nav-icon fas fa-cogs"></i>
                        <p>
                            Operaciones
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?php echo $root; ?>views/clientes/" class="nav-link ">
                                <i class="fas fa-list-alt nav-icon"></i>
                                <p> Registro de precios</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo $root; ?>views/productos/" class="nav-link">
                                <i class="fas fa-shopping-cart nav-icon"></i>
                                <p> Requisición de pedidos</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo $root; ?>views/proveedores/" class="nav-link">
                                <i class="fas fa-box nav-icon"></i>
                                <p> Visualización de pedidos</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link ">
                        <i class="nav-icon fas fa-chart-line"></i>
                        <p>
                            Reportes
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?php echo $root; ?>" class="nav-link ">
                                <i class="far fa-circle nav-icon"></i>
                                <p> Estado de Cuenta</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo $root; ?>" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p> Requisiciones</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo $root; ?>" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p> Lista de Precios</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo $root; ?>" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p> Pedidos</p>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
    </div>
</aside>