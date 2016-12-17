<?php
class Utilities{
	public static function getConnection(){
		include_once "DbPDO.php";
		$db = new DbPDO("sqlsrv", "localhost", "1433", "luis", "root", "showntop");
		return $db;
	}
        
        public static function sendEmail($toAddress){
            require_once "Mail.php";
            $from = 'juanlhiciano.social@gmail.com';
            $to = $toAddress;
            $subject = 'Valoracion Online';
            $body = "Hi,\n\nHow are you?";

            $headers = array(
                'From' => $from,
                'To' => $to,
                'Subject' => $subject
            );

            $smtp = Mail::factory('smtp', array(
                    'host' => 'ssl://smtp.gmail.com',
                    'port' => '465',
                    'auth' => true,
                    'username' => 'juanlhiciano.social@gmail.com',
                    'password' => 'JuanLHiciano@21'
                ));

            $mail = $smtp->send($to, $headers, $body);

            if (PEAR::isError($mail)) {
                echo('<p>' . $mail->getMessage() . '</p>');
            } else {
                echo('<p>Message successfully sent!</p>');
            }
        }
}
?>