<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Cuarto B</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="css/estilo.css">
    
</head>

<body>
    <header>
        <img src="img/Banner.jpeg" alt="Banner" width="100%" height="210px">
    </header>
    <nav>
        <ul>
            <li><a href="index.php?option=Inicio">Inicio</a></li>
            <li><a href="index.php?option=Nosotros">Nosotros</a></li>
            <li><a href="index.php?option=Servicios">Servicios</a></li>
            <li><a href="index.php?option=Contactos">Contactos</a></li>
             <?php
        if(isset($_SESSION["rol"]) &&
           $_SESSION["rol"] == "administrador"){
        ?>
            <li>
                <a href="index.php?option=Productos">
                    Productos
                </a>
            </li>
        <?php } ?>
        </ul>
    </nav>
    <article> 
        <?php
        $mvc = new Controller();
        $mvc->EnlacesPaginasController();
        ?>    
    </article>
    <footer>
        <p>Derechos reservados &copy; 2026</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    <script src="js/factura.js"></script>

</body>

</html>