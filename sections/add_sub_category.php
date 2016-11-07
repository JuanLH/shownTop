<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->

<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
    if(isset($_POST['submit']))
    {
        //var_dump($_POST);exit();
        insert_sub_category();
    }
    
    $name=$description="";
    $category=$_GET['category'];
    $nameErr=$descriptionErr="";
    $cod_category;
    
    
    
    function insert_sub_category(){
        if(!(empty($_POST['category']) || empty($_POST['subcategory']) ||
                empty($_POST['description']))){
            include('../clases/Utilities.php');
            $db = Utilities::getConnection();
            $result = $db->getCategory($_GET["category"]);
            
            if($result){
                $cod_category=$result['cod_categoria'];
            }
            else{
                echo "Error";exit();
            }
            $array = array(
                "name_sub_categoria"=>$_POST['subcategory'],
                "cod_categoria"=>$cod_category,
                "description"=>$_POST['description']
            );
            $result = $db->insertSubCategory($array);
            //var_dump($result);exit();
            if(!$result){
                header("Location:index.php?section=add_sub_category");
                exit();
            }
            else{
               $subcategory = $_POST['subcategory'];
               $category = $_GET["category"];
               $_POST = array();
                header("Location:index.php?subcategory=$subcategory");
                exit(); 
            }
        }
        
    }
    
?>

<h2>Add Sub_Category</h2>
<p><span class="error">* required field.</span></p>
<form method="post" id="usrform" 
      action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"].'?section=add_sub_category&category='.$category.'');?>">  
  Categoria: <br><input type="text" name="category" value="<?php echo $category;?>">
  <span class="error">* <?php echo $nameErr;?></span>
  <br><br>
  Sub Categoria: <br><input type="text" name="subcategory" value="<?php echo $name;?>">
  <span class="error">* <?php echo $nameErr;?></span>
  <br><br>
  Descripcion: <br><input type="text" name="description" value="<?php echo $description;?>">
  <span class="error">* <?php echo $descriptionErr;?></span>
  <input type="submit" name="submit" value="GRABAR">  
</form>

