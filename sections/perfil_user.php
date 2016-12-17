 
<?php 
    include "../clases/Utilities.php";
    $db = Utilities::getConnection();
    if(isset($_POST['submit'])){
        
        $db->modificarUsuariofull($_POST, $_FILES['image']);
    }
    $usuario = $db->getUsuario($_SESSION["user"]);
    //var_dump($_POST);
    //var_dump($usuario);
?>
<form action="" name="userForm" method="post" enctype = "multipart/form-data" 
       onsubmit="return validateForm()">
    <input type="hidden" name="id" value="<?=$_SESSION['user']?>">
    
    <label for="mail">Nombre:</label><br>
    <input type="text" name="nombre" value = "<?=$usuario['nombre']?>"></input><br>
    
    <label for="msg">Direccion:</label><br>
    
    <input type="text" list="paises"  name="direccion" value = "<?=$db->getUbicacion($usuario['direccion'])[1]?>" ></input>
    <input type="text" name = "direccion_provincia" value="<?=$db->getUbicacion($usuario['direccion'])[2]?>"><br>
    <datalist id="paises">
                <?php
                    $db = Utilities::getConnection();
                    $paises= $db->getListPaises();
                    foreach($paises as $row){
                        echo "<option value='".$row['nicename']."' id='".$row['cod_pais']."'>".$row['cod_pais']."</option>";
                    }
                   
                ?>
    </datalist>
    <label for="enlace">Sexo:</label><br>
    <input type="radio" <?php echo ($usuario['sexo']=='female')?'checked':'' ?> name="gender" value="female" >Female</input>
    <input type="radio" <?php echo ($usuario['sexo']=='male')?'checked':'' ?>  name="gender"  value="male" >Male</input><br>
    
    <label for="ubicacion">Correo:</label><br>
    <input type="text"  name="correo" value ="<?=$usuario['correo']?>"></input><br>
    
    <label for="picture">Foto:</label> 
    <input type="file"  name="image" />
    <img name="foto" src="<?=$usuario['foto']?>" ><br>
    
    <label for="telefono">Telefono:</label><br>
    <input type="text"  name="telefono" value ="<?=$usuario['telefono']?>" ></input><br>
    
    <label for="whatsapp">Whatsapp:</label><br>
    <input type="text"  name="whatsapp" value ="<?=$usuario['whatsapp']?>"></input><br>
    
    <label for="web">Web:</label><br>
    <input type="text"  name="web" value ="<?=$usuario['web']?>"></input><br>
    
    <label for="fecha">Fecha de Nacimiento:</label><br>  	
    <input type="date" value ="<?=$usuario['fecha_nacimiento']?>" name="fecha_nacimiento"><br>
    
    <label for="estado_civil">Estado civil:</label><br>
    <input type="radio" <?php echo ($usuario['estado_civil']=='soltero')?'checked':'' ?> name="estado" value="soltero">Soltero/a</input>
    <input type="radio"  <?php echo ($usuario['estado_civil']=='casado')?'checked':'' ?> name="estado"  value="casado">Casado/a</input><br>
    
    <label for="identificacion">Identificacion:</label><br>
    <input type="text"  name="identificacion" value ="<?=$usuario['identificacion']?>"></input><br>
   
    <button type="submit" name="submit" >Actualizar</button>
</form>
        
<script>
    function validateEmail(email) {
        var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return re.test(email);
    }

    
    function validateForm() {
    var name = document.userForm.nombre;
    var address  = document.userForm.direccion;
    var gender = document.userForm.gender;
    var email = document.userForm.correo;
    var picture = document.userForm.foto;
    var phone = document.userForm.telefono;
    var whatsapp = document.userForm.whatsapp;
    var web = document.userForm.web;
    var birthdate = document.userForm.fecha_nacimiento;
    var status = document.userForm.estado;
    var id = document.userForm.identificacion;
    
    
    if (name.value == "") {
        name.focus();
        return false;
    }
    else if(address.value == "") {
        address.focus();
        return false;
    }else if(gender.value == "") {
        geender.focus();
        return false;
    }else if(!validateEmail(email.value)) {
        email.focus();
        return false;
    }else if(picture.src == "") {
        picture.focus();
        return false;
    }
    else if(phone.value == "") {
        phone.focus();
        return false;
    }
    else if(whatsapp.value == "") {
        whatsapp.focus();
        return false;
    }
    else if(web.value == "") {
        web.focus();
        return false;
    }
    else if(web.value == "") {
        web.focus();
        return false;
    }
    else if(birthdate.value==""){
        birthdate.focus();
        return false;
    }
    else if(status.value==""){
        status.focus();
        return false;
    }
    else if(id.value==""){
        id.focus();
        return false;
    } 
}
</script>
