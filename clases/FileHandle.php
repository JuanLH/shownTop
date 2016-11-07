<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of FileHandle
 *
 * @author Juan Luis Hiciano
 * RETURN CODE
 *  -1 = extension not allowed
 */
class FileHandle {
    //put your code here
    private $extensions= array("jpeg","jpg","png","gif","ico");
    private $path="../uploads/";
    /*
     *  RETURN CODE
     *  -1 = extension not allowed  
     *  -2 = File size must be exactely or less than 2 MB
     *   1 = success
     */
    public function upload($file,$id_category,$doc_type,$id_user){
       /* ## */
       $file_name = $file['name'];
       $file_size = $file['size'];
       $file_tmp = $file['tmp_name'];
       $file_type = $file['type'];
       
       $part = explode('.',$file_name);
       $file_ext=strtolower(end($part));
       
        if(in_array($file_ext,$this->extensions)===false){
            return -1;
        }
        else if($file_size > 2097152) {
            return -2;
        }
        else{
            /*Insert into database here*/
            move_uploaded_file($file_tmp,$this->path.$file_name);
            return 1;
        }
   }
   
   public function getFile($name){}
   
}
