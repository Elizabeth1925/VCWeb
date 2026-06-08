<?php
    // Incluir controladores necesarios
    require_once "controllers/controllersTienda/usuario.php";
    require_once "controllers/controllersTienda/producto.php";
    require_once "controllers/controllersTienda/factura.php";
    require_once "controllers/controllersTienda/venta.php";

    // Obtener lista de productos disponibles
    $productos = ProductoController::listar();

    // Procesar agregar producto a la factura
    FacturaController::agregar();
    FacturaController::eliminar();
    FacturaController::vaciar();
    VentaController::finalizarCompra();
    $factura = VentaController::obtenerSiguienteFactura();
?>

<!-- SECCIÓN: VERIFICAR SI EL USUARIO ESTÁ AUTENTICADO -->
<?php if(!isset($_SESSION["usuario"])){ ?>

     <!--LOGIN -->
    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card shadow" >
                    <div class="card-header bg-danger text-white">
                        Iniciar Sesión
                    </div>

                    <div class="card-body">

                        <form method="post">

                            <div class="mb-3">
                                <label class="form-label">
                                    Usuario
                                </label>

                                <input type="text" name="usuario"
                                    class="form-control"
                                    required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">
                                    Contraseña
                                </label>

                                <input
                                    type="password"
                                    name="clave"
                                    class="form-control"
                                    required>
                            </div>

                            <button
                                class="btn btn-danger w-100"
                                type="submit">
                                Ingresar
                            </button>

                        </form>

                    </div>    

                </div>

            </div>

        </div>

    </div>

    <?php UsuarioController::login(); ?>
<?php } else { ?>

    <!-- SECCIÓN: USUARIO AUTENTICADO -->
    <h2>
        Bienvenido <?php echo $_SESSION["usuario"]; ?>
    </h2>
    <hr>

    <!-- VERIFICAR TIPO DE USUARIO: ADMINISTRADOR O CLIENTE -->
    <?php if($_SESSION["rol"] == "administrador"){ ?>


        <!-- PANEL ADMINISTRADOR -->
        <h3>Panel Administrador</h3>
        <p>Puede administrar los productos desde el menú Productos.</p>

    <?php } else { ?>

        <!-- SECCIÓN: MOSTRAR PRODUCTOS PARA CLIENTE -->

        <!-- LISTAR TODOS LOS PRODUCTOS -->

        <div class="container-fluid">

            <div class="row">

                <!-- PRODUCTOS -->
                <div class="col-md-8">

                    <h3 class="mb-4">Productos Disponibles</h3>

                    <div class="row">

                <?php foreach($productos as $p){ ?>

                <div class="col-md-4 mb-4">

                    <div class="card h-100 shadow">

                        <img src="<?php echo $p['ima_pro']; ?>" class="card-img-top"
                            height="220"
                            alt="Producto">

                        <div class="card-body">

                            <h5 class="card-title">
                                <?php echo $p['nom_pro']; ?>
                            </h5>

                            <p class="card-text">
                                <?php echo $p['des_pro']; ?>
                            </p>

                            <h4 class="text-success">
                                $<?php echo $p['pre_pro']; ?>
                            </h4>

                            <form method="post">

                                <input type="hidden" name="id" value="<?php echo $p['id_pro']; ?>">
                                <input type="hidden" name="nombre" value="<?php echo $p['nom_pro']; ?>">
                                <input type="hidden" name="precio" value="<?php echo $p['pre_pro']; ?>">

                                <div class="mb-2">

                                    <label class="form-label">
                                        Cantidad
                                    </label>

                                    <input type="number" name="cantidad" min="1" value="1"
                                        class="form-control cantidad"
                                        data-precio="<?php echo $p['pre_pro']; ?>">

                                </div>

                                <p>
                                    Subtotal:
                                    <strong class="subtotal">
                                        $<?php echo $p['pre_pro']; ?>
                                    </strong>
                                </p>

                                <button type="submit" name="agregar" class="btn btn-success w-100" onclick="return agregarProducto();"> Agregar </button>
                            </form>

                        </div>

                    </div>

                </div>

                <?php } ?>

                </div>

            </div>

             <!-- FACTURA -->
            <div class="col-md-4">

                <?php $total = 0; ?>

                <div class="card shadow factura-fija">

                    <div class="card-header bg-success text-white">
                        Factura
                    </div>

                    <div class="card-body">

                        <p>
                            <strong>Cliente:</strong>
                            <?php echo $_SESSION["usuario"]." ".$_SESSION["apellido"]; ?>
                        </p>

                        <p>
                            <strong>Fecha:</strong>
                            <?php echo date("d/m/Y"); ?>
                        </p>

                        <p>
                            <strong>N° Factura:</strong>
                            <?php echo str_pad($factura["siguiente"], 4, "0", STR_PAD_LEFT); ?></p>
                        </p>

                        <table class="table table-bordered table-hover">

                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Producto</th>
                                    <th>Cantidad</th>
                                    <th>Subtotal</th>
                                    <th>Acción</th>
                                </tr>

                            </thead>

                            <tbody>

                                <?php
                                if(isset($_SESSION["factura"])){

                                    foreach($_SESSION["factura"] as $indice => $item){

                                        $total += $item["subtotal"];
                                ?>

                                <tr>

                                    <td><?php echo $item["id"]; ?></td>

                                    <td><?php echo $item["nombre"]; ?></td>

                                    <td><?php echo $item["cantidad"]; ?></td>

                                    <td>
                                        $<?php echo number_format($item["subtotal"],2); ?>
                                    </td>

                                    <td>

                                        <a href="index.php?option=Nosotros&eliminar=<?php echo $indice; ?>" class="btn btn-danger btn-sm"
                                            onclick="return eliminarProducto();">
                                            Eliminar

                                        </a>

                                    </td>

                                </tr>

                                <?php
                                    }
                                }
                                ?>

                                <tr>

                                    <td colspan="4">
                                        <strong>Total</strong>
                                    </td>

                                    <td>
                                        <strong>
                                            $<?php echo number_format($total,2); ?>
                                        </strong>
                                    </td>

                                </tr>

                            </tbody>

                        </table>

                        <div class="d-flex gap-2">
                            <button
                                type="button"
                                class="btn btn-secondary"
                                onclick="window.print()">

                                Imprimir Factura

                            </button>

                            <form method="post">
                                <button type="submit" name="vaciar" class="btn btn-warning"
                                    onclick="return vaciarFactura();">
                                    Vaciar Factura
                                </button>
                            </form>

                            <form method="post">
                            <button type="submit" name="finalizarCompra" class="btn btn-primary"
                                    onclick="return finalizarCompra();">
                                    Finalizar Compra
                                </button>
                            </form>
                        </div>

                    </div>

                </div>

            </div>

        </div>

    <?php } ?>

    <!-- BOTÓN CERRAR SESIÓN PARA ADMIN Y CLIENTE -->
    <div class="d-flex gap-2 mt-3">
        <form action="logout.php" method="post">
            <button type="submit" class="btn btn-danger">
                Cerrar Sesión
            </button>
        </form>
    </div>
   
<?php } ?>