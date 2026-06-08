 <?php
       session_start();
        require_once "controllers/controller.php";
        require_once "models/model.php";
        $mvc = new Controller();
        $mvc->Plantilla();
?> 
