<?php
require_once('cliente_cancelacion_formas_digitales.php');
header('Content-type: text/html; charset=utf-8');
try {

	set_time_limit(0);
	date_default_timezone_set("America/Mexico_City");


	#Datos que ocupara el XML 
	//$filename ="resources/Cancelacion1_Request.xml"; 
	$certFile = "resources/CSD_Pruebas_CFDI_LAN7008173R5.cer";
	$keyFile = "resources/CSD_Pruebas_CFDI_LAN7008173R5.key";
	$rfc="LAN7008173R5";
	$folio="98CA3B09-2B20-4B08-A04E-A9B7814BA74F";
	$pass="12345678a";

	$clienteFD = new ClienteCancelacionFormasDigitales();

	$autentica = new Autenticar();
	$autentica->usuario = "pruebasWS";
	$autentica->password = "pruebasWS";

	$parametros = new Parametros();
	$parametros->accesos = $autentica;
	
	#Recibe el XML sellado 
	$parametros->Cancelacion_1 = $clienteFD->sellarXML($certFile, $keyFile,$rfc,$folio,$pass,$autentica);;	

	$responseTimbre = $clienteFD->cancelar($parametros);

		var_dump($responseTimbre);
		die();

	if (isset($responseTimbre->acuseCFDI->error)) {
		echo "codigoErr: " . $responseTimbre->acuseCFDI->error . "<br>";
	}

	if ($responseTimbre->acuseCFDI->xmlTimbrado) {
		echo 'XML TMIBRADO:<BR> <textarea>' . $responseTimbre->acuseCFDI->xmlTimbrado . '</textarea>';
	
	}
} catch (SoapFault $e) {
	print("Auth Error:::: $e");
}



class Autenticar
{
	public $usuario;
	public $password;
}


class Parametros
{
	public $accesos;
	public $Cancelacion_1;
}
