<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<div class="muro">
    <form action="index.php?section=upload" method="post" enctype = "multipart/form-data">
    
    <div>
        <label for="mail">Archivo</label>
        <input type="file"  name="image" />
    </div>
    <div>
        <label for="msg">Descripcion:</label><br>
        <textarea  name="user_message"></textarea>
    </div>
    
    <div class="button">
        <button type="submit">Send your message</button>
    </div>
</form>
   
</div>