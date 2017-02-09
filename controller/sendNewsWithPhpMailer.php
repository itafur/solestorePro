<?php 

date_default_timezone_set("America/Bogota");

$destinatario = "isaitafur@gmail.com"; 
$asunto = "Este mensaje es de prueba";

$bodyContent = "<div style='width: 590px; font-family: arial; font-size: 12px; color: #555555; line-height: 14pt'>
						<div style='padding-top: 20px; padding-left: 50px; padding-right: 50px;'>
							<img src='https://cdn3.iconfinder.com/data/icons/meanicons-4/512/meanicons_58-48.png' alt='Sivere' style='border:none;'></img>
							<h3><font color='#0AB03E'>Felicitaciones por tu compra</font></h3>
						 </div>
						 <div>
						  <div style='padding-left: 50px; padding-right: 50px; padding-bottom: 1px;'>
							<hr/>
							<div style='margin-bottom: 30px;'>
							  <br>
							  <div style='margin-bottom: 20px;'>
								<b>Fecha de compra:</b> ".date('d/m/Y H:i:s')."<br>
							  </div>
							</div>
							<div style='font-size: 9px; color: #707070;'>
							  <br>No responder a este correo.<br>
							  By Sivere Software.<br>
							</div>
						  </div>
						</div>
					</div>";

$cuerpo = $bodyContent; 

//para el envío en formato HTML 
$headers = "MIME-Version: 1.0\r\n"; 
$headers .= "Content-type: text/html; charset=iso-8859-1\r\n"; 

//dirección del remitente 
//$headers .= "From: Isacho Pacho <isaitafur@gmail.com>\r\n"; 

//dirección de respuesta, si queremos que sea distinta que la del remitente 
//$headers .= "Reply-To: mariano@desarrolloweb.com\r\n"; 

//ruta del mensaje desde origen a destino 
//$headers .= "Return-path: holahola@desarrolloweb.com\r\n"; 

//direcciones que recibián copia 
//$headers .= "Cc: maria@desarrolloweb.com\r\n"; 

//direcciones que recibirán copia oculta 
//$headers .= "Bcc: pepe@pepe.com,juan@juan.com\r\n"; 

if(!mail($destinatario,$asunto,$cuerpo,$headers)) {
   echo "ocurrio fallo al enviar";
   exit;	
}

echo "Enviado";

?>