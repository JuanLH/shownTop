<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->

<div>       
<?php
    if(isset($_SESSION['user'])){
        /*Contenido con el usuario logueado*/
        echo "<div class='lateralMenu'>";
            include ('fragments/lateralMenu.php');
        echo "</div>";    
        include ('../sections/muro.php');
    }
    else{
        echo '<p>Esta es una pagina de practica para proyecto de Diseño';
        echo ' y programacion de paginas web</p><br>';
        echo '<p>Necesita loguearse para interactuar en la red social</p>';
    }
?>

