<?php
    $respuesta = '';
    if(isset($_POST['submit'])){
        include '../clases/Utilities.php';
        echo Utilities::sendEmail($_POST['correo']);
        
    }
?>

<form method="POST" action="">
        Correo:<input name="correo" type="text" value=""/><br><br>
        <input name="submit" type="submit" value="Enviar"/>
       
</form>