<?php
ini_set( 'display_errors', '1' );
ini_set("error_reporting",E_ALL);
error_reporting(E_ALL);

/* $to_email = 'karthikeyan.ra@photoninfotech.net,deepak.dixit@avantorsciences.com,john.suarez-beard@avantorsciences.com,prakash.devendhiran@avantorsciences.com';
$subject = 'Testing PHP Mail from 192.168.20.45 Supplier Central New Production Environment';
$message = 'This mail is sent using the PHP mail function from Supplier Central New Production Environment';
// To send HTML mail, the Content-type header must be set
			$headers  = 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
			// Additional headers
			$headers .= "From: VWR Supplier Central <VWRsuppliercentral@VWRsuppliercentral.com>" . "\r\n";
			$headers .= "Reply-To: VWR Supplier Central <VWRsuppliercentral@VWRsuppliercentral.com>" . "\r\n";
			mail($to_email,$subject,$message,$headers); */
//$hostname = '{10.52.96.136:143/notls/norsh/novalidate-cert}INBOX';
$hostname = '{PECOMSCMAIL01.avantorsciences.com:995/notls/norsh/novalidate-cert}';
$username ='vwr';
$password='vwr@vwr$';
$inbox = imap_open($hostname, $username, $password) or die('Cannot connect to VWR mail: ' . imap_last_error());
var_dump($inbox);exit;
$emails = imap_search($inbox, 'UNSEEN');
if ($emails) {
foreach ($emails as $email_number) {

                                    $mail_contents = new stdClass;
			            $header_info = imap_headerinfo($inbox, $email_number);
			            $mail_subject = $header_info->subject;
			            $mail_subject = explode("ID", $mail_subject);                        
			            @$submission_id = $mail_subject[1];
				    print_r($submission_id)."<br>";

}
}


?>