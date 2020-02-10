<?php

header('Content-type: text/html; charset=utf-8');

try {

	set_time_limit(0);
    date_default_timezone_set("America/Mexico_City");

    $client = new SoapClient("http://dev33.facturacfdi.mx/WSCancelacionService?wsdl"); 

    $certFile = "resources/CSD_Pruebas_CFDI_LAN7008173R5.cer.pem";
	$keyFile = "resources/CSD_Pruebas_CFDI_LAN7008173R5.key.pem";

	$cert = file_get_contents($certFile);
	//$data_publicKey = str_replace(array('\n', '\r'), '', base64_encode($cert));
	#$data_publicKey = openssl_x509_parse(file_get_contents($cert),true);

	$key = file_get_contents($keyFile);
	//$data_privateKey = str_replace(array('\n', '\r'), '', base64_encode($key));
	#$data_privateKey = openssl_x509_parse(file_get_contents($key.'.pem'),true);

    $pass="12345678a";
    $fecha_actual = substr( date('c'), 0, 19);
    $list_folios = array();  
    $list_folios[0] = 'A9C36125-A7F4-48D9-B2C4-116F9B82BD32';

	$Accesos = new StdClass;
	$Accesos->usuario = "pruebasWS";
    $Accesos->password = "pruebasWS";

    $parametros = new StdClass;
    $parametros->rfcEmisor = 'LAN7008173R5';
    $parametros->fecha = $fecha_actual;
    $parametros->folios = $list_folios;
    $parametros->publicKey = $cert;
    $parametros->privateKey = $key;
    $parametros->password = $pass;
    $parametros->accesos = $Accesos;
    
    $responseCencelacion = $client->Cancelacion_1($parametros);
    
    var_dump($responseCencelacion);
    
} catch (SoapFault $e) {
	print("Auth Error:::: $e");
}
