<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->

<ul class="menu">
    <li><a href="index.php">Categorias</a> <a href="index.php?section=add_categoria">+</a>
    <ul>
    <?php 
        include('../clases/Utilities.php');
        $db = Utilities::getConnection();
        $listCat =$db->getlistCategory();
        
        while (list($cod_categoria,$name_categoria,$descripcion) = 
                $listCat->fetch(PDO::FETCH_BOTH)) {
            echo "<dd><li ><a href='index.php?category=".$name_categoria."' class='categories'>".$name_categoria."</a>"
                 . "<a href='index.php?section=add_sub_category&category=".$name_categoria."'>++</a><li>";
            echo "<ul>";
                $listSubCat=$db->getlistSubCategory($cod_categoria);
               
                while(list($cod_sub_cat,$name_sub_cat,$cod_cat,$desc) =     
                        $listSubCat->fetch(PDO::FETCH_NUM)){
                     echo "<dd><li ><a href='index.php?sub_category=".$name_sub_cat."' "
                          . "class='sub_categories'>".$name_sub_cat."</a> <li>";
                }
            echo "</ul>";
            
        }
    ?>
    </ul></li>    
    <li><a href="index.php?section=perfil_user">Perfil</a></li>
    <li><a href="#">Usuarios</a></li>
</ul>