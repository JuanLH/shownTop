 <form action="index.php?section=upload" method="post" enctype = "multipart/form-data">
    <label for="mail">Nombre:</label><br>
    <input type="text" name="nombre"></input><br>
    
    <label for="msg">Direccion:</label><br>
    <input type="text"  name="direccion"></input><br>
    
    <label for="enlace">Sexo:</label><br>
    <input type="radio" name="gender" value="female">Female</input>
  <input type="radio" name="gender"  value="male">Male</input><br>
    
    <label for="ubicacion">Correo:</label><br>
    <input type="text"  name="correo"></input><br>
    
    <label for="ubicacion">Foto:</label> <input type="file"  name="image" /><img src="../resources/add_picture.png" width="20px" height="20px"><br>
    <img src=""><br>
    
    <label for="telefono">Telefono:</label><br>
    <input type="text"  name="user_ubicacion"></input><br>
    
    <label for="whatsapp">Whatsapp:</label><br>
    <input type="text"  name="whatsapp"></input><br>
    
    <label for="web">Web:</label><br>
    <input type="text"  name="web"></input><br>
    
    <label for="fecha_nacimiento">Fecha de Nacimiento:</label><br>
    <input type="text"  name="fecha_nacimiento"></input><br>
    
    <label for="estado_civil">Estado civil:</label><br>
    <input type="text" name="estado_civil"></input><br>
    
    <label for="identificacion">Identificacion:</label><br>
    <input type="text"  name="identificacion"></input><br>
   
    <button type="submit">Send your message</button>
</form>
        <?php
        // put your code here
        ?>

