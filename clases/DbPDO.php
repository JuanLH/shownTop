<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
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
            $sql = 'SELECT codigo_usuario,nombre,sexo
                    ,correo,clave,web
                    ,fecha_registro
                    FROM [dbo].[usuarios] where estado = 0 and codigo_usuario ='.$cod;
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
        /*Entities:Usuario Methods-----------------------------------------*/
    }
?>  