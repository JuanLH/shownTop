<?php
class Utilities{
	public static function getConnection(){
		include "DbPDO.php";
		$db = new DbPDO("sqlsrv", "localhost", "1433", "luis", "root", "showntop");
		return $db;
	}
}
?>