<?php
require_once "controllers/controllersTienda/producto.php";

$productos = ProductoController::listar();

$editar = null;

if(isset($_GET["editar"])){
    $editar = ProductoController::buscarPorId($_GET["editar"]);
}
?>

<div class="container mt-4">

    <h2 class="mb-4">
        Administración de Productos
    </h2>

    <!-- FORMULARIO -->
    <div class="card shadow mb-4">

        <div class="card-header bg-danger text-white d-flex justify-content-between align-items-center">

            <span>
                <?php if($editar != null){ ?>
                    Editar Producto
                <?php }else{ ?>
                    Gestión de Productos
                <?php } ?>
            </span>

            <?php if($editar == null){ ?>

            <button
                class="btn btn-light btn-sm"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#formProducto">

                + Nuevo Producto

            </button>

            <?php } ?>

        </div>

        <div
            id="formProducto"
            class="collapse <?php echo ($editar != null) ? 'show' : ''; ?>">

        <div class="card-body">


            <form method="post">

                <input
                    type="hidden"
                    name="id"
                    value="<?php echo $editar["id_pro"] ?? ''; ?>">

                <div class="mb-3">

                    <label class="form-label">
                        Nombre
                    </label>

                    <input
                        type="text"
                        name="nombre"
                        class="form-control"
                        value="<?php echo $editar["nom_pro"] ?? ''; ?>"
                        required>

                </div>

                <div class="mb-3">

                    <label class="form-label">
                        Descripción
                    </label>

                    <input
                        type="text"
                        name="descripcion"
                        class="form-control"
                        value="<?php echo $editar["des_pro"] ?? ''; ?>"
                        required>

                </div>

                <div class="mb-3">

                    <label class="form-label">
                        Precio
                    </label>

                    <input
                        type="number"
                        step="0.01"
                        name="precio"
                        class="form-control"
                        value="<?php echo $editar["pre_pro"] ?? ''; ?>"
                        required>

                </div>

                <div class="mb-3">

                    <label class="form-label">
                        URL Imagen
                    </label>

                    <input
                        type="text"
                        name="imagen"
                        class="form-control"
                        value="<?php echo $editar["ima_pro"] ?? ''; ?>"
                        required>

                </div>

                <?php if($editar != null){ ?>

                    <button
                        type="submit"
                        name="editarProducto"
                        class="btn btn-warning">

                        Actualizar Producto

                    </button>

                    <a
                        href="index.php?option=Productos"
                        class="btn btn-secondary">

                        Cancelar

                    </a>

                <?php }else{ ?>

                    <button
                        type="submit"
                        class="btn btn-success">

                        Guardar Producto

                    </button>

                <?php } ?>

            </form>

        </div>

    </div>

    <?php

        ProductoController::actualizar();
        ProductoController::guardar();
        ProductoController::eliminar();

    ?>

    <!-- TABLA -->
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
                            <th width="180">Acciones</th>

                        </tr>

                    </thead>

                    <tbody>

                        <?php foreach($productos as $p){ ?>

                        <tr>

                            <td>

                                <img
                                    src="<?php echo $p["ima_pro"]; ?>"
                                    width="80"
                                    height="80"
                                    style="object-fit:cover;"
                                    class="rounded">

                            </td>

                            <td>
                                <?php echo $p["nom_pro"]; ?>
                            </td>

                            <td>
                                <?php echo $p["des_pro"]; ?>
                            </td>

                            <td>
                                <span class="badge bg-success fs-6">
                                    $<?php echo $p["pre_pro"]; ?>
                                </span>
                            </td>

                            <td>

                                <a
                                    href="index.php?option=Productos&editar=<?php echo $p['id_pro']; ?>"
                                    class="btn btn-warning btn-sm">

                                    Editar

                                </a>

                                <a
                                    href="index.php?option=Productos&id=<?php echo $p['id_pro']; ?>"
                                    class="btn btn-danger btn-sm"
                                    onclick="return confirm('¿Desea eliminar este producto?');">

                                    Eliminar

                                </a>

                            </td>

                        </tr>

                        <?php } ?>

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>
