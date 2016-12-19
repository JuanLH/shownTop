
<?php
    include "../clases/Utilities.php";
     $db = Utilities::getConnection();
     $stage = 0;
     $users;
    if(isset($_POST['submit'])){
        $users=$db->getUsers($_POST);
        $stage = 1;
        //var_dump($users);
    }
    
?>

<?php
if($stage == 0)
{
?>
    <div class="publicacion">  
    <h1>Filtros de Usuarios</h1></br>
    <form action="" name="userForm" method="post" enctype = "multipart/form-data">

        <label for="nombre">Nombre:</label></br>
        <input type="text" name="nombre" value=""></input></br>

        <label for="correo">Correo:</label></br>
        <input type="text"  name="correo" value =""></input></br>

        <label for="sexo">Sexo:</label></br>
        <input list="sexo" type="text" name="sexo">
        <datalist id="sexo">
            <option value="">VACIO</option>
            <option value="female">MUJER</option>
            <option value="male">HOMBRE</option> 
        </datalist></br>

        <label for="estado_civil">Estado Civil:</label></br>
        <input list="estado_civil"  type="text" name="estado_civil">
        <datalist id="estado_civil">
            <option value="">VACIO</option>
            <option value="soltero">SOLTERO</option>
            <option value="casado">CASADO</option> 
        </datalist></br></br>
        <label for="pais">Pais:</label></br>
        <input list="paises"  type="text" name="pais">
        <datalist id="paises">
            <?php
                $db = Utilities::getConnection();
                $paises= $db->getListPaises();
                foreach($paises as $row){
                    echo "<option value='".$row['nicename']."' id='".$row['cod_pais']."'>".$row['nicename']."</option>";
                }

            ?>
        </datalist></br></br>

        <button type="submit" name="submit" >BUSCAR</button>
    </form>

    </div>

<?php
}
else{
    if(isset($users)){
        if(sizeof($users)==0){
            echo "<div class='publicacion'>";
            echo "<h2>Sin Resultados</h2>";
            echo "</div>";
        }
        else{
       
        echo "<table id='tuser'>";
        $count=0;
        
        for($i=0;$i<sizeof($users);$i++){
            if($count==0){
                echo "<tr>";
            }
            $count++;
            ?>

            <td>  
            <div id="usuario" class="publicacion">
            <h3>Codigo</h3>
            <?=$users[$i]['cod_usuario']?>
            <h3>Foto</h3>
            <img src="<?=$users[$i]['foto']?>">
            <h3>nombre</h3>
            <?=$users[$i]['nombre']?>
            <h3>Direccion</h3>
            <?=$db->getUbicacionText($users[$i]['direccion'])?>
            <h3>Sexo</h3>
            <?=$users[$i]['sexo']?>
            <h3>Correo</h3>
            <?=$users[$i]['correo']?>
            <h3>Telefono</h3>
            <?=$users[$i]['telefono']?>
            <h3>Fecha Nacimiento</h3>
            <?=$users[$i]['fecha_nacimiento']?>
            <h3>Fecha Registro</h3>
            <?=$users[$i]['fecha_registro']?>
            </div>
            </td>    

            



            <?php
            if($count== 3){
                echo "</tr>";
                $count=0;
            }

        }
       echo "</tr></table>";
        }
    }
    }
?>