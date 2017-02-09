<?php
	

				date_default_timezone_set("America/Bogota");

				$bodyContent = "<div style='width: 590px; font-family: arial; font-size: 12px; color: #555555; line-height: 14pt'>
								    <div style='padding-top: 20px; padding-left: 50px; padding-right: 50px;'>
								        <img src='https://cdn3.iconfinder.com/data/icons/meanicons-4/512/meanicons_58-48.png' alt='Sivere' style='border:none;'></img>
								        <h3><font color='#0AB03E'>MENSAJE GENERADO DESDE CRON JOB </font></h3>
								     </div>
								     <div>
								      <div style='padding-left: 50px; padding-right: 50px; padding-bottom: 1px;'>
								        <hr/>
								        <div style='margin-bottom: 30px;'>
								          <br>
								          <div style='margin-bottom: 20px;'>
								            <b>Fecha de generacion:</b> ".date('d/m/Y H:i:s')."<br>
								          </div>
								        </div>
								      </div>
								    </div>
								</div>";

				$subject = 'WebMaster- Mensaje Generado desde Cron Job for SendMail';
				$addresses =  "isaitafur@gmail.com";
				$headers = "MIME-Version: 1.0\r\n"; 
				$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
				$headers .= "X-Priority: 3\n";
				$headers .= "X-MSMail-Priority: Normal\n";
				$headers .= "X-Mailer: php\n";
				
				mail($addresses,$subject,$bodyContent,$headers);

?>