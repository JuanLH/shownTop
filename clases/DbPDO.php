<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
ini_set("xdebug.var_display_max_children", -1);
ini_set("xdebug.var_display_max_data", -1);
ini_set("xdebug.var_display_max_depth", -1);
error_reporting(E_ALL);
    class DbPDO{
        private $host;
        private $password;
        private $dbname;
        private $port;
        private $username;
        private $conn;
        private $driverName;
        
        public function __construct($driverName, $host, $port, $username, $password, $dbname) {
                $this->host = $host;
                $this->password = $password;
                $this->dbname = $dbname;
                $this->port = $port;
                $this->username = $username;
                $this->driverName = $driverName;
                $this->connect();
        }
        
        private function connect() {
            switch($this->driverName) {
                case 'sqlsrv':
                    $dsn = $this->driverName . ":Server=" . $this->host . ";Database=" . $this->dbname;
                    break;
                default:
                    $dsn = $this->driverName.':dbname='.$this->dbname.';host='.$this->host.'; port = '.$this->port.'';
            }

            try {
                $this->conn = new PDO($dsn, $this->username, $this->password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
            } catch (PDOException $e) {
                echo 'Connection failed: ' . $e->getMessage();
                return false;
            }

        }
        
        public function execSelect ($sql){
            return $this->conn->query($sql);
        }
        
        public function exec ($sql){
            return $this->conn->exec($sql);
        }
        
        public function closeConn(){
            $this->conn=null;
        }
        
        public function getConn(){
            return $this->conn;
        }
        /*Entities:Categorias Methods*/
        public function insertCategory($array){
            try{ 
                
                $prep = $this->conn->prepare('INSERT INTO dbo.categorias
                                            (name_categoria,descripcion)
                                                         VALUES (?,?);');
                $prep->bindParam(1,$array["name"]);
                $prep->bindParam(2,$array["description"]);
                $prep->execute(); 
            }
            catch(PDOException $e){
                echo 'Connection failed:<br><br> ' . $e->getMessage();
                return false;
            }
            return $prep;
        }
        
        public function getCategory($name){
            $sql = 'SELECT cod_categoria,name_categoria
                 FROM dbo.categorias where name_categoria = \''.$name.'\';';
            try{
                $result = $this->execSelect($sql);
                
                return $result ? $result->fetch(PDO::FETCH_ASSOC) : null;         
            }
            catch(PDOException $e){
                echo 'Connection failed:<br><br> ' . $e->getMessage();
                return false;
            }
        }
        public function getlistCategory(){
            $sql = 'SELECT cod_categoria,name_categoria ,descripcion
                    FROM dbo.categorias;';
            try{
                $result = $this->execSelect($sql);
                
                return $result ;      
            }
            catch(PDOException $e){
                echo 'Connection failed:<br><br> ' . $e->getMessage();
                return false;
            }
        }
        /*Entities:sub_categorias Methods*/
        public function insertSubCategory($array){
            try{ 
                
                $prep = $this->conn->prepare('INSERT INTO dbo.sub_categorias
                                            (name_sub_categoria
                                            ,cod_categoria
                                            ,descripcion)
                                              VALUES (?,?,?);');
                $prep->bindParam(1,$array["name_sub_categoria"]);
                $prep->bindParam(2,$array["cod_categoria"]);
                $prep->bindParam(3,$array["description"]);
                $prep->execute(); 
            }
            catch(PDOException $e){
                echo 'Connection failed:<br><br> ' . $e->getMessage();
                return false;
            }
            return $prep;
        }
        
        public function getlistSubCategory($cod_category){
            $sql = 'SELECT [cod_sub_categoria]
                    ,[name_sub_categoria]
                    ,[cod_categoria]
                    ,[descripcion]
                FROM [showntop].[dbo].[sub_categorias]
                where cod_categoria ='.$cod_category.';';
            
            try{
                $result = $this->execSelect($sql);
                return $result ;      
            }
            catch(PDOException $e){
                echo 'Connection failed:<br><br> ' . $e->getMessage();
                return false;
            }
        }
        
        public function getSubCategory($name_subcategory){
            $sql = 'SELECT [cod_sub_categoria]  
                FROM [showntop].[dbo].[sub_categorias]
                where [name_sub_categoria] =\''.$name_subcategory.'\';';
          
            try{
                $result = $this->execSelect($sql);
                $id = $result->fetch(PDO::FETCH_NUM);
                
                return $id[0] ;      
            }
            catch(PDOException $e){
                echo 'Connection failed:<br><br> ' . $e->getMessage();
                return false;
            }
        }
        
        /*Entities:Usuario Methods*/
        public function registrarUsuario($array){
            try{
                $result = $this->execSelect('select max(cod_usuario) from dbo.usuarios');
                //print("Return next row as an array indexed by column name\n <br>");
                $result= $result->fetch(PDO::FETCH_NUM, PDO::FETCH_ORI_NEXT);
                
                if($result[0]==null){
                    $cod = 1;
                }
                else{
                    $cod=$result[0]+1;
                }
                
                $prep = $this->conn->prepare('INSERT INTO [dbo].[usuarios]
                                                ([nombre]
                                                ,[tipo_usuario]
                                                ,[sexo]
                                                ,[correo]
                                                ,[clave]
                                                ,[estado])
                                          VALUES
                                               (?,?,?,?,?,?);');
              
                $prep->bindParam(1,$array["name"]);
                $prep->bindParam(2,$array["userType"]);
                $prep->bindParam(3,$array["gender"]);
                $prep->bindParam(4,$array["email"]);
                $prep->bindParam(5,$array["password"]);
                $prep->bindParam(6,$array["status"]);
                
        
                //var_dump($array["status"]);exit();
                $prep->execute(); 
            }
            catch(PDOException $e){
                echo 'Connection failed:<br><br> ' . $e->getMessage();
                return false;
            }
            return $prep;
        }

        public function modificarUsuario($array){
            try{
                $prep = $this->conn->prepare('UPDATE dbo.usuarios
                                               SET 
                                                  nombre = ?
                                                  ,sexo = ?
                                                  ,correo = ?
                                                  ,clave = ?
                                                  ,web = ?
                                                  ,fehca_registro = ?
                                                  ,estado = ?
                                             WHERE codigo_usuario = ?');
                $prep->bindParam(1,$array[0]);
                $prep->bindParam(2,$array[1]);
                $prep->bindParam(3,$array[2]);
                $prep->bindParam(4,$array[3]);
                $prep->bindParam(5,$array[4]);
                $prep->bindParam(6,$array[5]);
                $prep->bindParam(7,$array[6]);
                $prep->bindParam(8,$array[7]);
                $prep->execute();
            }
            catch(PDOException $e){
                echo 'Connection failed:<br><br> ' . $e->getMessage();
                return false;
            }
            return $prep;
        }

        public function getUsuarios(){
            $result;
            $sql = 'SELECT codigo_usuario,nombre,sexo
                    ,correo,clave,web
                    ,fehca_registro
                    FROM [dbo].[usuarios] where estado = 0';
            try{
                $result = $this->execSelect($sql);     
                return $result;    
            }
            catch(PDOException $e){
                echo 'Connection failed:<br><br> ' . $e->getMessage();
                return false;
            }
              
        }

        public function getUsuario($cod){
            $result;
            $sql = 'SELECT cod_usuario,nombre,sexo
                    ,correo,clave,web
                    ,fecha_registro
                    FROM [dbo].[usuarios] where estado = 0 and cod_usuario ='.$cod;
            try{
                $result = $this->execSelect($sql); 
                //var_dump($result);    
                return $result ? $result->fetch(PDO::FETCH_ASSOC) : null;     
            }
            catch(PDOException $e){
                echo 'Connection failed:<br><br> '. $e->getMessage();
                return false;
            }
              
        }

        public function login($user,$pass){
            $result;
            $sql = 'SELECT cod_usuario
                    FROM [dbo].[usuarios] where estado = 0 and nombre =\''.$user.'\' and clave=\''.$pass.'\'';
             echo $sql;   
            try{
                $result = $this->execSelect($sql); 
                //var_dump($result);    
                return $result ? $result->fetch(PDO::FETCH_ASSOC) : null;     
            }
            catch(PDOException $e){
                
                return null;
            }

        }
        /*Entities:documentos Methods-----------------------------------------*/
        
         public function insertDocumento($array){
            try{
                
                
                $prep = $this->conn->prepare('INSERT INTO [dbo].[documento]
                                                ([cod_usuario]
                                                ,[cod_tipo_documento]
                                                ,[texto]
                                                ,[ubicacion]
                                                ,[foto]
                                                ,[valoracion]
                                                ,[cod_sub_categoria]
                                                ,[vinculo]
                                                ,[estado]
                                                ,[tumbnail])
                                             VALUES
                                                (?
                                                ,?
                                                ,?
                                                ,?
                                                ,?
                                                ,?
                                                ,?
                                                ,?
                                                ,?
                                                ,?)');
              
                $prep->bindParam(1,$array["cod_usuario"]);
                $prep->bindParam(2,$array["cod_tipo_documento"]);
                $prep->bindParam(3,$array["texto"]);
                $prep->bindParam(4,$array["ubicacion"]);
                $prep->bindParam(5,$array["foto"]);
                $prep->bindParam(6,$array["valoracion"]);
                $prep->bindParam(7,$array["cod_sub_categoria"]);
                $prep->bindParam(8,$array["vinculo"]);
                $prep->bindParam(9,$array["estado"]);
                $prep->bindParam(10,$array["tumbnail"]);
                //var_dump($array["status"]);exit();
                $prep->execute(); 
            }
            catch(PDOException $e){
                echo 'Connection failed:<br><br> ' . $e->getMessage();
                return false;
            }
            return $prep;
        }
        
        function parms($string,$data) {
        $indexed=$data==array_values($data);
        foreach($data as $k=>$v) {
            if(is_string($v)) $v="'$v'";
            if($indexed) $string=preg_replace('/\?/',$v,$string,1);
            else $string=str_replace(":$k",$v,$string);
        }
        return $string;
    }
        
        private function checkValoracion($cod_usuario,$cod_documento){
            $sql = "SELECT [cod_documento],[valoracion]
                    FROM [showntop].[dbo].[documento] 
                    WHERE cod_usuario  = :cod_usuario AND 
                    id_doc_original =:cod_documento AND cod_tipo_documento= 6;";
            $sth =$this->conn->prepare($sql);
            $sth->bindParam(':cod_usuario',$cod_usuario);    
            $sth->bindParam(':cod_documento',$cod_documento); 
            $sth->execute();
            $data=array('cod_usuario'=>$cod_usuario,'cod_documento'=>$cod_documento);
             //echo "<script type='text/javascript'>alert('".$this->parms($sql, $data)."')</script>";
            if($sth->fetchColumn()>0){
                return true;
            }
            else{
                return false;
            }
            
        }
        
        public function getDocument($cod_documento){
            $sql = "select * from "
            . "documento where cod_documento =".$cod_documento;
            //metodo #1 recomendado para un solo resultado
            try {
                $stmt =$this->conn->prepare($sql);
                $stmt->execute();
                return $row = $stmt->fetch();
            }catch(PDOException $e){
                echo 'Connection failed:<br><br> ' . $e->getMessage();
                return false;
            }
        }
        
        public function insertValoracion($cod_documento,$valoracion){
            session_start();
            $array =  $this ->getDocument($cod_documento);
            
            if($this->checkValoracion($_SESSION['user']
                    ,$cod_documento)){
                //Update valoracion
                try{
                    $prep = $this->conn->prepare('UPDATE [dbo].[documento]
                                                SET [fecha] = ?
                                                   ,[valoracion] = ?
                                                   ,[estado] = ?
                                              WHERE [cod_usuario] = ?
                                              AND [cod_tipo_documento] = ?
                                              AND [id_doc_original] = ?');
                    $date = date("Y-m-d h:i:sa");
                    $tipo_doc = 6;
                    $prep -> bindParam(1, $date);                          
                    $prep->bindParam(2,$valoracion);
                    $prep->bindParam(3,$array['estado']);
                    $prep->bindParam(4,$_SESSION['user']);
                    $prep->bindParam(5,$tipo_doc);
                    $prep->bindParam(6,$array["cod_documento"]);
                   
                    //var_dump($array["status"]);exit();
                    $prep->execute(); 
                }
                catch(PDOException $e){
                    echo 'Connection failed:<br><br> ' . $e->getMessage();
                    return false;
                }
            }
            else{
                try{
                    $prep = $this->conn->prepare('INSERT INTO [dbo].[documento]
                                                    ([cod_usuario]
                                                    ,[cod_tipo_documento]
                                                    ,[valoracion]
                                                    ,[cod_sub_categoria]
                                                    ,[id_doc_original]
                                                    ,[estado])
                                                 VALUES
                                                    (?,?,?,?,?,?)');
                    $tipo_doc = 6;
                    $estado = 0;
                    
                    $prep->bindParam(1,$_SESSION['user']);
                    $prep->bindParam(2,$tipo_doc);
                    $prep->bindParam(3,$valoracion);
                    $prep->bindParam(4,$array["cod_sub_categoria"]);
                    $prep->bindParam(5,$array["cod_documento"]);
                    $prep->bindParam(6,$estado);

                    //var_dump($array["status"]);exit();
                    $prep->execute(); 
                }
                catch(PDOException $e){
                    echo 'Connection failed:<br><br> ' . $e->getMessage();
                    return false;
                }
                
                
                
            }
            $result = $this->exec('UPDATE documento
                    SET 
                    valoracion = (SELECT SUM (valoracion) FROM documento 
                    where cod_tipo_documento = 6 and id_doc_original = '.$cod_documento.') 
                    WHERE cod_documento = '.$cod_documento.' and cod_tipo_documento < 6');
            
            
        }
        
        public function getValoracion($cod_documento){
            $sql = "SELECT SUM ([valoracion]) FROM [dbo].[documento] 
                where [cod_tipo_documento] = 6 and id_doc_original = ".$cod_documento.";";
            //metodo #1 recomendado para un solo resultado
            $stmt =$this->conn->prepare($sql);
            $stmt->execute();
            $row = $stmt->fetch();
            //echo "<script type='text/javascript'>alert('".  var_dump($row)."')</script>";
            return $row[0];
                
            //metodo #2 para mas de un resultado
            /*foreach ($this->execSelect($sql) as $row) {
                if($tipo_valoracion == '+'){
                    $valoracion = $row['valoracion']+1;
                }
                else if($tipo_valoracion == '-'){
                    $valoracion = $row['valoracion']-1;
                }   
            }*/
        }
        
        public function getListDocSubC($subCat){
            
            $cod_subCat = (int)$this->getSubCategory($subCat);
            
            $sql = 'SELECT [cod_documento]
                        ,[fecha]
                        ,[cod_usuario]
                        ,[cod_tipo_documento]
                        ,[texto]
                        ,[ubicacion]
                        ,[foto]
                        ,[valoracion]
                        ,[id_doc_original]
                        ,[cod_sub_categoria]
                        ,[vinculo]
                        ,[estado]
                        ,[tumbnail]
                    FROM [dbo].[documento] where [cod_sub_categoria] = '.$cod_subCat.'
                    AND [cod_tipo_documento] < 6 order by valoracion desc';
            
            try{
                //var_dump($sql);exit();
                $statement = $this->conn->prepare($sql);
                $statement->execute();
                $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                //var_dump($result);exit();
                return $result;
            }
            catch(PDOException $e){
                echo 'Connection failed:<br><br> ' . $e->getMessage();
                return false;
            }
            
        }
        
    }
?>  