<?php
error_reporting(E_ALL);
$send_to = array('lslaymaker@microflex.com','betty.lemley@gbo.com','Jamie_Mcdougall@vwr.com','lakshmi@photon.in','balasubramani.k@photoninfotech.net'
	        );
$subject = 'VWR Supplier Central: Test Mail';
$message = '<div style=" border: 1px solid #C4C4C4; margin: 45px auto 35px; width: 620px; float:left; border-top:none;">
                <div class="email_head" style="float: left;height: 63px;">
                  <img src="http://32.64.6.137/sites/all/themes/vwr/images/ribbon-header3.jpg" width="620" height="57" alt="logo" />
               </div>
                <div class="wel_cont conf_cont" style="padding-left: 34px;padding-top: 20px;width: 560px;float:left">
                  This is a test email from VWR Supplier Central. Please confirm receipt by replying to vwr@vwrsuppliercentral.com with the comments  "received". Thanks for your quick reply so that we can bring new enhancements to the Supplier Central website!
                  <br><br>
                  Thanks,<br>
                  Jamie McDougall<br>
                  VWR International<br>
                  Marketing Planning and Operations Manager<br>
                  (610) 386-1455<br> 
                  Jamie_McDougall@vwr.com<br><br>                  
                </div>                
            </div>';
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";            
$headers .= 'From: VWR Supplier Central <vwrsuppliercentral@vwrsuppliercentral.com>' . "\r\n" .
           'Reply-To: vwr@vwrsuppliercentral.com' . "\r\n" .
           'X-Mailer: PHP/' . phpversion();
foreach ($send_to as $to) {   
   $mail = mail($to, $subject, $message, $headers);
   if ($mail) {      
     email_logs($to); 
   }   
}

function email_logs($to) {
   $filename = "bidirectional_test.txt";      
   $fh = fopen($filename, 'a+') or die("can't open file");
   $data = $to .' - Sent, ';
   fwrite($fh, $data);      
   fclose($fh);
}
?> 
