<?php
// Incluir controladores necesarios
require_once "controllers/controllersTienda/usuario.php";
require_once "controllers/controllersTienda/producto.php";
require_once "controllers/controllersTienda/factura.php";
require_once "controllers/controllersTienda/venta.php";

// Obtener lista de productos disponibles
if (isset($_SESSION["rol"]) && $_SESSION["rol"] == "administrador") {
    $productos = ProductoController::listar();
} else {
    $productos = ProductoController::listarParaClientes();
}

if (isset($_GET["limpiarFactura"])) {
    unset($_SESSION["facturaImpresion"]);
    unset($_SESSION["compraFinalizada"]);
}

// Procesar agregar producto a la factura
FacturaController::agregar();
FacturaController::eliminar();
FacturaController::vaciar();
VentaController::finalizarCompra();
$factura = VentaController::obtenerSiguienteFactura();
?>

<!-- SECCIÓN: VERIFICAR SI EL USUARIO ESTÁ AUTENTICADO -->
<?php if (!isset($_SESSION["usuario"])) { ?>

    <!--LOGIN -->
    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card shadow">
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

    <?php if(isset($_SESSION["mensaje"])){ ?>

        <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">

            <?php echo $_SESSION["mensaje"]; ?>

            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert">
            </button>

        </div>

    <?php
        unset($_SESSION["mensaje"]);
    }
    ?>

    <hr>
    
    

    <!-- VERIFICAR TIPO DE USUARIO: ADMINISTRADOR O CLIENTE -->
    <?php if ($_SESSION["rol"] == "administrador") { ?>

        <!-- PANEL ADMINISTRADOR -->
        <?php
        $productos = ProductoController::listar();
        ?>
        <h3 class="mb-4">
            Panel Administrador
        </h3>
        <p class="text-muted">
            Resumen de productos registrados en el sistema.
        </p>
        <div class="card shadow">
            <div class="card-header bg-dark text-white">
                Lista de Productos
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle">
                        <thead class="table-danger">
                            <tr>
                                <th>Imagen</th>
                                <th>Nombre</th>
                                <th>Descripción</th>
                                <th>Precio</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($productos as $p) { ?>
                                <tr>
                                    <td>
                                        <img
                                            src="<?php echo $p['ima_pro']; ?>"
                                            width="80"
                                            height="80"
                                            class="rounded producto-admin-img">
                                    </td>
                                    <td>
                                        <?php echo $p['nom_pro']; ?>
                                    </td>
                                    <td>
                                        <?php echo $p['des_pro']; ?>
                                    </td>
                                    <td>
                                        <span class="badge bg-success fs-6">
                                            $<?php echo number_format($p['pre_pro'], 2); ?>
                                        </span>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    <?php } else { ?>

        <!-- SECCIÓN: MOSTRAR PRODUCTOS PARA CLIENTE -->
        <!-- LISTAR TODOS LOS PRODUCTOS -->
        <div class="container-fluid">
            <div class="row">

                <!-- PRODUCTOS -->
                <div class="col-md-8">
                    <h3 class="mb-4">Productos Disponibles</h3>
                    <div class="row">
                        <?php foreach ($productos as $p) { ?>
                            <div class="col-md-4 mb-4">
                                <div class="card h-100 shadow">
                                    <img src="<?php echo $p['ima_pro']; ?>" class="card-img-top"
                                        alt="Producto">
                                    <div class="card-body">
                                        <h5 class="card-title">
                                            <?php echo $p['nom_pro']; ?>
                                        </h5>
                                        <p class="card-text">
                                            <?php echo $p['des_pro']; ?>
                                        </p>
                                       <h4 class="text-success fw-bold mb-3">
    $<?php echo number_format($p['pre_pro'],2); ?>
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
                <?php

                if (isset($_SESSION["compraFinalizada"])) {
                    $facturaMostrar = $_SESSION["facturaImpresion"];
                } else {
                    $facturaMostrar = $_SESSION["factura"] ?? [];
                }

                ?>
                <!-- FACTURA -->
                <div class="col-md-4">
                    <?php $total = 0; ?>
                    <div class="card shadow factura-fija" id="facturaImprimir">
                        <div class="card-header bg-success text-white">
                            Factura
                        </div>
                        <div class="card-body">
                            <p>
                                <strong>Cliente:</strong>
                                <?php echo $_SESSION["usuario"] . " " . $_SESSION["apellido"]; ?>
                            </p>
                            <p>
                                <strong>Fecha:</strong>
                                <?php echo date("d/m/Y"); ?>
                            </p>
                            <p>
                                <strong>N° Factura:</strong>
                                <?php echo str_pad($factura["siguiente"], 4, "0", STR_PAD_LEFT); ?>
                            </p>
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Producto</th>
                                        <th>Cantidad</th>
                                        <th>Subtotal</th>
                                        <th class="col-accion">Acción</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if (!empty($facturaMostrar)) {
                                        foreach ($facturaMostrar as $indice => $item) {
                                            $total += $item["subtotal"];
                                    ?>
                                            <tr>
                                                <td><?php echo $item["id"]; ?></td>
                                                <td><?php echo $item["nombre"]; ?></td>
                                                <td><?php echo $item["cantidad"]; ?></td>
                                                <td>
                                                    $<?php echo number_format($item["subtotal"], 2); ?>
                                                </td>
                                                <td class="col-accion">
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
                                    <tr class="total-factura">
                                        <td colspan="4">TOTAL</td>
                                        <td>$<?php echo number_format($total, 2); ?></td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="d-flex gap-2 mt-3">
                                <form method="post">
                                    <button type="submit" name="vaciar" id="btn-vaciar" class="btn btn-warning"
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
    <?php if (isset($_SESSION["compraFinalizada"])) { ?>
        <div class="modal fade" id="modalCompra" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-success text-white">
                        <h5 class="modal-title">
                            Compra Finalizada
                        </h5>
                    </div>
                    <div class="modal-body">
                        <p>
                            La compra se realizó correctamente.
                        </p>
                        <p>
                            ¿Desea imprimir la factura?
                        </p>
                    </div>
                    <div class="modal-footer">
                        <a
                            href="index.php?option=Nosotros&limpiarFactura=1"
                            class="btn btn-secondary">
                            No
                        </a>
                        <button
                            type="button"
                            class="btn btn-success"
                            onclick="imprimirFactura()">
                            Sí, imprimir
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                var modal = new bootstrap.Modal(
                    document.getElementById('modalCompra')
                );
                modal.show();
            });
        </script>
    <?php
        unset($_SESSION["compraFinalizada"]);
    }
    ?>

    <script>
        function imprimirFactura() {
            var modal =
                bootstrap.Modal.getInstance(
                    document.getElementById('modalCompra')
                );
            modal.hide();
            setTimeout(function() {
                window.print();
                window.location.href =
                    "index.php?option=Nosotros&limpiarFactura=1";
            }, 500);
        }
    </script>