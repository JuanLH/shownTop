<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->

<ul class="menu">
    <li><a href="#">Categorias</a> <a href="index.php?section=add_categoria">+</a>
    <ul>
    <?php 
        include('../clases/Utilities.php');
        $db = Utilities::getConnection();
        $result =$db->getlistCategory();
        
        while (list($cod_categoria,$name_categoria,$descripcion) = 
                $result->fetch(PDO::FETCH_BOTH)) {
            echo "<dd><li ><a href='#' class='categories'>".$name_categoria."</a> <a href='index.php?section=add_sub_category&category=".$name_categoria."'>++</a><li>";
        }
    ?>
    </ul></li>    
    <li><a href="#">Perfil</a></li>
    <li><a href="#">Usuarios</a></li>
</ul>