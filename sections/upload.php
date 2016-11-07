<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->

<?php
    include ('../clases/FileHandle.php');
    $fileHandle = new FileHandle();
    if(isset($_FILES['image'])){
        $result = $fileHandle->upload($_FILES['image'], 0, 0, 0);
    }
    else
        echo "no is set";
    
    header("Location:index.php");
    exit();
?>

